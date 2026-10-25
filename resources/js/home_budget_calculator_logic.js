document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('calculatorModal');
    const openBtn = document.getElementById('openCalculatorBtn');
    const closeBtn = document.getElementById('closeCalculatorBtn');

    const savingsInput = document.getElementById('savings');
    const savingsSlider = document.getElementById('savings-slider');
    const emiInput = document.getElementById('emi');
    const emiSlider = document.getElementById('emi-slider');
    const tenureInput = document.getElementById('tenure');
    const tenureSlider = document.getElementById('tenure-slider');

    const savingsValue = document.getElementById('savings-value');
    const emiValue = document.getElementById('emi-value');
    const tenureValue = document.getElementById('tenure-value');
    const budgetRange = document.getElementById('budget-range');
    const budgetWords = document.getElementById('budget-words');

// Open the modal
openBtn.addEventListener('click', () => {
  modal.classList.remove('hidden');
  calculateBudget();
});

// Close the modal
closeBtn.addEventListener('click', () => {
  modal.classList.add('hidden');
});

// Also close on Escape key
window.addEventListener('keydown', e => {
  if (e.key === 'Escape') modal.classList.add('hidden');
});

    // Currency formatter
    function formatCurrency(value) {
        return new Intl.NumberFormat('en-IN').format(value);
    }

    // Number to words
    function numberToWords(n) {
        const a = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven',
            'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen',
            'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        function inWords(num) {
            if ((num = num.toString()).length > 9) return 'Overflow';
            const n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{3})$/);
            if (!n) return;
            let str = '';
            str += (+n[1] !== 0) ? (a[+n[1]] || b[n[1][0]] + ' ' + a[n[1][1]]) + ' Crore ' : '';
            str += (+n[2] !== 0) ? (a[+n[2]] || b[n[2][0]] + ' ' + a[n[2][1]]) + ' Lakh ' : '';
            str += (+n[3] !== 0) ? (a[+n[3]] || b[n[3][0]] + ' ' + a[n[3][1]]) + ' Thousand ' : '';
            str += (+n[4] !== 0) ? (a[+n[4]] || b[n[4][0]] + ' ' + a[n[4][1]]) + ' ' : '';
            return str.trim() + 'Rupees only';
        }

        return inWords(n);
    }

    function calculateBudget() {
        const savings = parseInt(savingsInput.value);
        const emi = parseInt(emiInput.value);
        const tenureYears = parseInt(tenureInput.value);

        const r = 9.75 / 100 / 12;
        const n = tenureYears * 12;
        const loanAmount = emi * ((Math.pow(1 + r, n) - 1) / (r * Math.pow(1 + r, n)));
        const totalBudget = Math.round(savings + loanAmount);

        // Display budget
        const displayValue = totalBudget >= 10000000
            ? (totalBudget / 10000000).toFixed(2) + ' Cr'
            : (totalBudget / 100000).toFixed(2) + ' Lakh';

        savingsValue.textContent = formatCurrency(savings);
        emiValue.textContent = formatCurrency(emi);
        tenureValue.textContent = tenureYears;
        budgetRange.textContent = displayValue;
        budgetWords.textContent = numberToWords(totalBudget);
    }

    function syncInputs(slider, input) {
        slider.addEventListener('input', () => {
            input.value = slider.value;
            calculateBudget();
        });
        input.addEventListener('input', () => {
            slider.value = input.value;
            calculateBudget();
        });
    }

    syncInputs(savingsSlider, savingsInput);
    syncInputs(emiSlider, emiInput);
    syncInputs(tenureSlider, tenureInput);
});
