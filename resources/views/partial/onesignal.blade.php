<link rel="manifest" href="{{ getAsset('plugins/onesignal/manifest.json') }}" />
<script src="//cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "{{ config('services.onesignal.app_id') }}",
      notifyButton: {
        enable: true,
      },
    });

  });
</script>