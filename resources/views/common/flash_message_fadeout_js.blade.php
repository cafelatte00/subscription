<script>
    // フラッシュメッセージをフェードアウト jQuery
    $(document).ready(function(){
        let flashMessage = $('#flash-message');
        if(flashMessage.length){
            setTimeout(function(){
                flashMessage.fadeOut();
            }, 3000);
        }
    });
</script>
