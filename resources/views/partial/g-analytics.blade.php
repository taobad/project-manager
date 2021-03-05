@if (strlen(config('system.g_analytics_tracking_id')))
<!-- Global site tag (gtag.js) - Google Analytics TODO Remove on production -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{config('system.g_analytics_tracking_id')}}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', '{{config('system.g_analytics_tracking_id')}}');
</script>
@endif