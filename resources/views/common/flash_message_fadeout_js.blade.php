<script>
    // フラッシュメッセージを４秒後に消す JavaScript
    // document.addEventListener('DOMContentLoaded', function(){
    //     //フラッシュメッセージがある場合
    //     const flashMessage = document.getElementById('flash-message');
    //     if(flashMessage){
    //         setTimeout(function(){
    //             flashMessage.style.display = 'none';
    //         }, 4000);
    //     }
    // });

    // フラッシュメッセージをフェードアウト jQuery
    $(document).ready(function(){
        let flashMessage = $('#flash-message');
        if(flashMessage.length){
            setTimeout(function(){
                flashMessage.fadeOut();
            }, 4000);
        }
    });

</script>
