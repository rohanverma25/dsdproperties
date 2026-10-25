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
    // Production serves public files under /public/, so build the worker path from asset().
    $pushWorkerPath  = ltrim(preg_replace('#/+#', '/', parse_url(asset(config('push.worker_path')), PHP_URL_PATH)), '/');
    $pushWorkerScope = '/' . dirname($pushWorkerPath) . '/';
@endphp
@if($pushAppId && !request()->is('admin', 'admin/*', 'seller', 'seller/*'))
<style>
/* ── Push prompt (OneSignal slidedown) in DSD brand style ── */
#onesignal-slidedown-container #onesignal-slidedown-dialog{width:500px !important;max-width:calc(100% - 24px) !important;margin:14px auto 0 !important;padding:22px 22px 18px !important;border-radius:16px !important;border-top:4px solid #008080 !important;font-family:'Plus Jakarta Sans',-apple-system,'Segoe UI',Roboto,Arial,sans-serif !important;color:#011f4b !important;box-shadow:0 18px 50px rgba(1,31,75,.22),0 2px 8px rgba(1,31,75,.08) !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-body-icon{width:52px !important;height:52px !important;border-radius:14px;background:linear-gradient(135deg,#008080,#011f4b);box-shadow:0 6px 16px rgba(0,128,128,.3)}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-body-icon img{display:none !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-body-icon::before{content:'';position:absolute;inset:0;margin:auto;width:26px;height:26px;background:no-repeat center/contain url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9'/%3E%3Cpath d='M10.3 21a1.94 1.94 0 0 0 3.4 0'/%3E%3C/svg%3E")}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-body-icon::after{content:'';position:absolute;top:-4px;right:-4px;width:12px;height:12px;border-radius:50%;background:#FF5C00;border:2px solid #fff}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-body-message{width:calc(100% - 52px) !important;padding:2px 0 0 14px !important;font-size:16.5px !important;font-weight:700 !important;line-height:1.4 !important;color:#011f4b !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-body-message::after{content:'Free \00B7  No spam \00B7  Turn off anytime';display:block;margin-top:5px;font-size:12.5px;font-weight:500;color:#64748b;letter-spacing:.01em}
#onesignal-slidedown-container #onesignal-slidedown-dialog .tagging-container{display:grid !important;grid-template-columns:1fr 1fr;gap:8px;margin:18px 0 !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .tagging-container-col{display:contents !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .tagging-container-col > div > div{display:none}
#onesignal-slidedown-container #onesignal-slidedown-dialog .onesignal-category-label{float:none !important;width:100% !important;height:auto !important;min-height:46px;box-sizing:border-box !important;margin:0 !important;padding:11px 12px 11px 42px !important;display:flex !important;align-items:center;border:1.5px solid #e2e8f0;border-radius:10px;background:#f8fafc;font-size:14px !important;font-weight:600;line-height:1.3 !important;color:#334155 !important;cursor:pointer;transition:border-color .15s,background .15s}
#onesignal-slidedown-container #onesignal-slidedown-dialog .onesignal-category-label:hover{border-color:#99d6d6}
#onesignal-slidedown-container #onesignal-slidedown-dialog .onesignal-category-label:has(input:checked){border-color:#008080;background:#effaf9;color:#011f4b !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .onesignal-category-label .onesignal-category-label-text{white-space:normal !important;overflow:visible !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .onesignal-category-label .onesignal-checkmark{top:50% !important;left:12px !important;transform:translateY(-50%);width:18px !important;height:18px !important;border-radius:5px !important;background:#fff !important;border:1.5px solid #cbd5e1;box-sizing:border-box !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .onesignal-category-label .onesignal-category-label-input:checked ~ .onesignal-checkmark{background:#008080 !important;border-color:#008080}
#onesignal-slidedown-container #onesignal-slidedown-dialog .onesignal-category-label .onesignal-checkmark::after{top:1px !important;left:5px !important;width:4px !important;height:9px !important;border-width:0 2px 2px 0 !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-footer{display:flex !important;flex-direction:row-reverse;align-items:center;gap:10px}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-footer .clearfix{display:none !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-button{float:none !important;justify-content:center;margin:0 !important;border-radius:10px !important;font-size:15px !important;font-weight:700 !important;letter-spacing:.01em !important;padding:12px 22px !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-button.primary{background:#FF5C00 !important;box-shadow:0 6px 16px rgba(255,92,0,.3) !important;min-width:150px}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-button.primary:hover{background:#e65200 !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-button.secondary{color:#64748b !important;background:transparent !important;font-weight:600 !important}
#onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-button.secondary:hover{color:#011f4b !important}
@media (max-width:520px){
  #onesignal-slidedown-container #onesignal-slidedown-dialog{padding:18px 16px 16px !important;margin-top:10px !important}
  #onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-body-icon{width:44px !important;height:44px !important;border-radius:12px}
  #onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-body-icon::after{top:-4px;right:-4px}
  #onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-body-message{width:calc(100% - 44px) !important;font-size:15px !important;padding-left:12px !important}
  #onesignal-slidedown-container #onesignal-slidedown-dialog .onesignal-category-label{font-size:13px !important;padding:10px 8px 10px 36px !important}
  #onesignal-slidedown-container #onesignal-slidedown-dialog .onesignal-category-label .onesignal-checkmark{left:10px !important}
  #onesignal-slidedown-container #onesignal-slidedown-dialog .slidedown-button.primary{flex:1}
}
</style>
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

    var savingId = null;
    function saveSubscription(OneSignal, id) {
        if (read('dsd_push_saved') === id || savingId === id) return;
        savingId = id;
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
            }).then(function (res) {
                if (res.ok) write('dsd_push_saved', id); // otherwise retry on the next page view
                savingId = null;
            }).catch(function () { savingId = null; });
        }, 2000);
    }

    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(async function (OneSignal) {
        try {
            await OneSignal.init({
                appId: @json($pushAppId),
                serviceWorkerPath:  @json($pushWorkerPath),
                serviceWorkerParam: { scope: @json($pushWorkerScope) },
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
            // The id often arrives in a later change event, after optedIn is already true.
            var now = ev.current || {};
            if (now.optedIn && now.id) saveSubscription(OneSignal, now.id);
        });

        var subscribed = OneSignal.User.PushSubscription.optedIn;
        // Catches browsers that subscribed before the id was saved (e.g. an earlier visit).
        if (subscribed && OneSignal.User.PushSubscription.id) saveSubscription(OneSignal, OneSignal.User.PushSubscription.id);
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
