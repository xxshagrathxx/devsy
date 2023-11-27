function submitState(el) {
    var $form = $(el),
    $requiredInputs = $form.find('input:required'),
    $submit = $form.find('button[type="submit"]');

    $submit.attr('disabled', 'disabled');

    $requiredInputs.keyup(function () {

    $form.data('empty', 'false');

    $requiredInputs.each(function() {
    if ($(this).val() === '') {
    $form.data('empty', 'true');
    }
    });

    if ($form.data('empty') === 'true') {
    $submit.attr('disabled', 'disabled').attr('title', 'fill in all required fields');
    } else {
    $submit.removeAttr('disabled').attr('title', 'click to submit');
    }
    });
}
