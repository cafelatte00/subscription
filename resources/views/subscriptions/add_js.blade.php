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
                // success:function(res){
                //     if(res.status=='success'){
                //         $('#addModal').modal('hide');
                //         $('#addSubscriptionForm')[0].reset();
                //         // $('#subscriptions_index').load(location.href+' #subscriptions_index');
                //         console.log(res.status);
                //     }
                // },error:function(err){
                //     let error = err.responseJSON;
                //     $.each(error.errors,function(index, value){
                //         $('.errMsgContainer').append('<span class="text-danger">'+value+'</span>'+'<br>');
                //     });
                // }
                dataType: "json",
            }).done(function(res){
                $('#addModal').modal('hide');
                $('#addSubscriptionForm')[0].reset();

                // 新規サブスクリプションを表示
                $('#index-flame').prepend('<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"><a href="'+ location.href + '/' + res.new_subscription.id +'"'+'><div class="p-6 text-gray-900">'
                    +res.new_subscription.title+'<br>'+res.new_subscription.price+'<br>'+res.new_subscription.frequency+'<br>'+res.new_subscription.first_payment_day+'<br>'+res.new_subscription.url+'<br>'+res.new_subscription.memo+
                    '</div></a></div>');

                    // ajax用のフラッシュメッセージ
                    showFlashMessage('成功しました。','success');
            }).fail(function(){
                showFlashMessage('通信の失敗しました','error');
            });
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
        background-color: #4CAF50;
        color: white;
    }

    .alert-error {
        background-color: #f44336;
        color: white;
    }
</style>
