(function ($) {
    'use strict';
    $(document).ready(function () {
        $(document).on('submit', '[data-action="m2a-form"]', function (e) {
            e.preventDefault();
            $('.m2a-submit').addClass('loading');
            var th = $(this);
            var dataStr = th.serialize();
            $('.m2a-response').html('');
            $(".m2a-response").removeClass('m2a-success m2a-error');
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                data: dataStr,
                success: function (data) {
                    if (data.response == 1) {
                        $(".m2a-response").html(data.success);
                        $(".m2a-response").addClass('m2a-success');
                        th.trigger("reset");
                    }else{
                        $(".m2a-response").html(data.error);
                        $(".m2a-response").addClass('m2a-error');
                    }
                }
            });
        });
    });
})(jQuery);
