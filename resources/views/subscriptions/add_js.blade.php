{{-- リクエスト ヘッダーにトークンを追加 --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    $(document).ready(function(){
        // subscription新規保存
        $(document).on('click','.add_subscription', function(e){
            e.preventDefault();
            let user_id = {{ Auth::user()->id }};
            let title = $('#title').val();
            let price = $('#price').val();
            let frequency = $('#frequency').val();
            let first_payment_day = $('#first_payment_day').val();
            let url = $('#url').val();
            let memo = $('#memo').val();

            $.ajax({
                url:"{{ route('subscriptions.add.subscription') }}",
                method: 'post',
                data:{user_id:user_id,title:title,price:price,frequency:frequency,first_payment_day:first_payment_day,url:url,memo:memo},
                dataType: "json",
            }).done(function(res){
                $('#addModal').modal('hide');
                $('#addSubscriptionForm')[0].reset();

                // 新規登録したサブスクをindexに追加
                $('#index-flame').prepend('<div class="p-4"><a href="'+ location.href + '/' + res.new_subscription.id +'"'+'><div class="bg-white p-6 rounded-lg"><div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></div><div></div><h2 class="text-lg text-gray-900 font-medium title-font mb-2">'
                    +res.new_subscription.title+'</h2><p class="leading-relaxed text-base">'+res.new_subscription.price+'円/'+res.new_subscription.frequency+'</p><p class="leading-relaxed text-base">次回支払日　2025年○月○日</p>'+
                    '</div></a></div>');

                    // ajax用のフラッシュメッセージ
                    showFlashMessage('サブスクを登録しました。','success');
            }).fail(function(error){
                // 以前のバリデーションエラーがあれば削除
                $('.errMsgContainer').empty();
                // バリデーションエラーをモーダルに表示
                $.each(error.responseJSON.errors, function(index, value){
                    $('.errMsgContainer').append('<span class="text-pink-600">'+value+'</span><br>');
                });
            });

            // クローズボタンがクリックされたら、バリデーションエラーを削除
            $('#closeButton').click(function(){
                $('.errMsgContainer').empty();
            });

            // キャンセルボタンがクリックされたら、バリデーションエラーを削除
            $('#cancelButton').click(function(){
                $('.errMsgContainer').empty();
            });

            //

        });

        // Ajax用のフラッシュメッセージ表示関数
        function showFlashMessage(message, type){
            let flashMessage = `<div class="flash-message alert alert-${type}">${message}</div>`;
            $('#ajax-flash-message').append(flashMessage);

            // メッセージが表示された後に非表示にする処理
            setTimeout(function(){
                $('.flash-message').fadeOut(function(){
                    $(this).remove();
                });
            }, 3000);
        }
    });
</script>

<style>
    /* フラッシュメッセージのスタイル */
    .flash-message {
        padding: 10px 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-size: 16px;
        display: inline-block;
        width: 100%;
        text-align: center;
    }

    .alert-success {
        background-color: #CFF4FC;
        color: gray;
    }

    .alert-error {
        background-color: #f44336;
        color: white;
    }
</style>
