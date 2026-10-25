{{--
    Website browser notifications (OneSignal Web SDK v16). Included in the <head> of every
    public layout, next to partials/ga4. Topics and tags: config/push.php.

    When we ask: on the 2nd visit, or once the reader has scrolled 60% of a long page.
    After "Not now" we wait 7 days. A browser that blocked notifications is never asked.
    The topic of the current page is pre-ticked, and on subscribe we record the page in
    site_push_subscribers (POST /push/subscribed) so /admin/push shows what brings subscribers.
    Any page can open the prompt itself with window.dsdPushAsk() (see the /news sidebar).
    Every public layout includes this, plus the standalone Saumitra Vihar page.
--}}
@php
    $pushAppId = config('push.app_id');
    $pushTopic = $pushAppId
        ? \App\Support\PushTopics::forView(['article' => $article ?? null, 'blog' => $blog ?? null], request()->path())
        : null;
@endphp
@if($pushAppId && !request()->is('admin', 'admin/*', 'seller', 'seller/*'))
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
<script>
(function () {
    var PAGE_TOPIC = @json($pushTopic);
    var TOPICS     = @json(array_keys(config('push.topics')));
    var SAVE_URL   = @json(route('push.subscribed'));
    var CSRF       = @json(csrf_token());
    var ASK_GAP_MS = 7 * 24 * 60 * 60 * 1000;

    function read(k)     { try { return localStorage.getItem(k); } catch (e) { return null; } }
    function write(k, v) { try { localStorage.setItem(k, v); } catch (e) {} }
    function track(name, params) { if (typeof window.gtag === 'function') window.gtag('event', name, params || {}); }

    // One visit per browser session.
    var visits = parseInt(read('dsd_push_visits') || '0', 10);
    try {
        if (!sessionStorage.getItem('dsd_push_session')) {
            sessionStorage.setItem('dsd_push_session', '1');
            visits += 1;
            write('dsd_push_visits', String(visits));
        }
    } catch (e) {}

    function chosenTopics(OneSignal) {
        var tags = {};
        try { tags = OneSignal.User.getTags() || {}; } catch (e) {}
        return TOPICS.filter(function (t) { return tags['topic_' + t] === '1'; });
    }

    function preTickPageTopic(OneSignal) {
        if (PAGE_TOPIC && chosenTopics(OneSignal).length === 0) {
            try { OneSignal.User.addTag('topic_' + PAGE_TOPIC, '1'); } catch (e) {}
        }
    }

    function saveSubscription(OneSignal, id) {
        // Give the category prompt a moment to write the ticked topics.
        setTimeout(function () {
            var topics = chosenTopics(OneSignal);
            if (topics.length === 0 && PAGE_TOPIC) {
                try { OneSignal.User.addTag('topic_' + PAGE_TOPIC, '1'); } catch (e) {}
                topics = [PAGE_TOPIC];
            }
            track('push_subscribe', { push_topics: topics.join(','), push_page_topic: PAGE_TOPIC || 'none' });
            fetch(SAVE_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ subscription_id: id, topics: topics, page_topic: PAGE_TOPIC, path: location.pathname }),
                credentials: 'same-origin'
            }).catch(function () {});
        }, 2000);
    }

    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(async function (OneSignal) {
        try {
            await OneSignal.init({
                appId: @json($pushAppId),
                serviceWorkerPath:  @json(config('push.worker_path')),
                serviceWorkerParam: { scope: @json(config('push.worker_scope')) },
                @if(app()->isLocal()) allowLocalhostAsSecureOrigin: true, @endif
                welcomeNotification: {
                    title:   'DSD Properties',
                    message: 'Thanks! You will now get important Lucknow property updates here.'
                },
                promptOptions: {
                    slidedown: {
                        prompts: [{
                            type: 'category',
                            autoPrompt: false,
                            text: {
                                actionMessage:        'Get Lucknow property news first. Which updates do you want?',
                                acceptButton:         'Allow',
                                cancelButton:         'Not now',
                                updateMessage:        'Which updates do you want?',
                                positiveUpdateButton: 'Save',
                                negativeUpdateButton: 'Cancel'
                            },
                            categories: @json(collect(config('push.topics'))->map(fn ($t, $k) => ['tag' => 'topic_' . $k, 'label' => $t['label']])->values())
                        }]
                    }
                }
            });
        } catch (e) {
            return; // wrong origin (e.g. localhost) or blocked script
        }

        if (!OneSignal.Notifications.isPushSupported()) return;

        OneSignal.User.PushSubscription.addEventListener('change', function (ev) {
            var now = ev.current || {}, before = ev.previous || {};
            if (now.optedIn && now.id && !before.optedIn) saveSubscription(OneSignal, now.id);
        });

        var subscribed = OneSignal.User.PushSubscription.optedIn;
        var blocked    = typeof Notification !== 'undefined' && Notification.permission === 'denied';

        // Manual entry point for on-page buttons (the /news sidebar box).
        window.dsdPushAsk = function () {
            preTickPageTopic(OneSignal);
            track('push_prompt', { push_trigger: 'button' });
            OneSignal.Slidedown.promptPushCategories({ force: true });
        };
        document.querySelectorAll('[data-push-ask]').forEach(function (el) {
            if (!subscribed && !blocked) el.hidden = false;
        });

        if (subscribed || blocked) return;
        if (Date.now() - parseInt(read('dsd_push_asked') || '0', 10) < ASK_GAP_MS) return;

        var asked = false;
        function ask(trigger) {
            if (asked) return;
            asked = true;
            write('dsd_push_asked', String(Date.now()));
            preTickPageTopic(OneSignal);
            track('push_prompt', { push_trigger: trigger });
            OneSignal.Slidedown.promptPushCategories();
        }

        if (visits >= 2) {
            setTimeout(function () { ask('second_visit'); }, 6000);
            return;
        }

        function onScroll() {
            var doc = document.documentElement;
            if (doc.scrollHeight < window.innerHeight * 1.5) return; // short page
            if ((window.scrollY + window.innerHeight) / doc.scrollHeight >= 0.6) {
                window.removeEventListener('scroll', onScroll);
                ask('scroll_60');
            }
        }
        window.addEventListener('scroll', onScroll, { passive: true });
    });
})();
</script>
@endif
