$(document).ready(function () {
  const $modal = $('#areaConverterModal');
  const $modalContent = $('#areaConverterContent');
  const $openBtn = $('#openAreaConverterBtn');
  const $closeBtn = $('#closeAreaConverterBtn');
  const $inputValue = $('#areaValue');
  const $resultDisplay = $('#conversionResult');
  const $unitNote = $('#unitNote');

  let selectedFrom = 'Bigha';
  let selectedTo = 'Biswa';

const units = {
  "Square Meter": 1,
  "Square Feet": 0.092903,
  "Gaj": 0.836127,
  "Bigha": 2529.285264,
  "Biswa": 125.452,
  "Katha": 126.441037,
  "Dhur": 16.93,
  "Acre": 4046.856422,
  "Hectare": 10000,
  "Square Yard": 0.836127,
  "Gajam": 0.836127,
  "Decimal": 40.468564,
  "Kanal": 505.857,
  "Marla": 25.292852
};


const populateUnits = () => {
  const popularUnits  = ["Square Feet", "Bigha", "Biswa", "Acre", "Gaj"];
  const allUnits = Object.keys(units).sort();

  // Ensure popular units are shown first and only once
  const remainingUnits = allUnits.filter(u => !popularUnits.includes(u));
  const orderedUnits = [...popularUnits, ...remainingUnits];

  const fromHtml = [];
  const toHtml = [];

  $.each(orderedUnits, function (_, unit) {
    const fromItem = `<div class="unit-item px-2 py-1 rounded hover:bg-teal-100" data-unit="${unit}">${unit}</div>`;
    const toItem = `<div class="unit-item px-2 py-1 rounded hover:bg-teal-100" data-unit="${unit}">${unit}</div>`;
    fromHtml.push(fromItem);
    toHtml.push(toItem);
  });

  $('#fromUnitWrapper').html(fromHtml.join(''));
  $('#toUnitWrapper').html(toHtml.join(''));

  // Preselect default units
  const selectedFrom = "Bigha";
  const selectedTo = "Biswa";

  $(`#fromUnitWrapper .unit-item[data-unit="${selectedFrom}"]`).addClass('bg-teal-200 font-semibold');
  $(`#toUnitWrapper .unit-item[data-unit="${selectedTo}"]`).addClass('bg-teal-200 font-semibold');
};


  const convert = () => {
    const value = parseFloat($inputValue.val() || 0);
    const from = selectedFrom;
    const to = selectedTo;

    if (!units[from] || !units[to]) return;

    const sqm = value * units[from];
    const converted = sqm / units[to];

    // Show results
    $resultDisplay.removeClass('hidden');
    $resultDisplay.find('p').first().text(`${value} ${from} =`);
    $resultDisplay.find('div').first().text(`${converted.toFixed(4)} ${to}`);

    const ratio = (units[from] / units[to]).toFixed(4);
    $unitNote
      .removeClass('hidden')
      .html(`💡1 <strong>${from}</strong> = <strong>${ratio} ${to}</strong> in <strong class="text-teal-700">Uttar Pradesh</strong>`);
  };

  const openModal = () => {
    $modal.removeClass('hidden');
    setTimeout(() => {
      $modal.addClass('opacity-100').removeClass('opacity-0');
      $modalContent.addClass('scale-100').removeClass('scale-95');
    }, 10);
  };

  const closeModal = () => {
    $modal.removeClass('opacity-100').addClass('opacity-0');
    $modalContent.removeClass('scale-100').addClass('scale-95');
    setTimeout(() => {
      $modal.addClass('hidden');
    }, 300);
  };

  // Event Handlers for custom unit selection
  $(document).on('click', '#fromUnitWrapper .unit-item', function () {
    $('#fromUnitWrapper .unit-item').removeClass('bg-teal-200 font-semibold');
    $(this).addClass('bg-teal-200 font-semibold');
    selectedFrom = $(this).data('unit');
    convert();
  });

  $(document).on('click', '#toUnitWrapper .unit-item', function () {
    $('#toUnitWrapper .unit-item').removeClass('bg-teal-200 font-semibold');
    $(this).addClass('bg-teal-200 font-semibold');
    selectedTo = $(this).data('unit');
    convert();
  });

  $('#swapUnitsBtn').on('click', function () {
    const temp = selectedFrom;
    selectedFrom = selectedTo;
    selectedTo = temp;

    $('#fromUnitWrapper .unit-item, #toUnitWrapper .unit-item').removeClass('bg-teal-200 font-semibold');
    $(`#fromUnitWrapper .unit-item[data-unit="${selectedFrom}"]`).addClass('bg-teal-200 font-semibold');
    $(`#toUnitWrapper .unit-item[data-unit="${selectedTo}"]`).addClass('bg-teal-200 font-semibold');
    convert();
  });

  $inputValue.on('input', convert);
  $openBtn.on('click', openModal);
  $closeBtn.on('click', closeModal);
  $modal.on('click', function (e) {
    if (e.target === this) closeModal();
  });

  // Initialize
  populateUnits();
  $inputValue.val(1);
  convert();
});


$('#openAreaConverterBtn').on('click', function () {
  $('#areaConverterModal').removeClass('hidden');

  setTimeout(() => {
    $('#areaValue').focus();
  }, 100);
});

