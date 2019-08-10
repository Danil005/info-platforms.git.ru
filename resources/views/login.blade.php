<meta name="csrf-token" content="{{ csrf_token() }}">

<script type="text/javascript" src="https://vk.com/js/api/openapi.js?162"></script>

<!-- VK Widget -->
<div id="vk_allow_messages_from_community"></div>
<script type="text/javascript">
    VK.Widgets.AllowMessagesFromCommunity("vk_allow_messages_from_community", {height: 22}, 170419631);
</script>

<script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous"></script>

<script type="text/javascript">

    VK.Observer.subscribe("widgets.allowMessagesFromCommunity.allowed", function f(userId) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/login/callback",
            type: "POST",
            data: {
                user_id: userId
            },
            dataType: "json"
        })
    });

</script>
