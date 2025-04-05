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
                let payDay = (res.new_subscription.next_payment_day === null) ? res.new_subscription.first_payment_day : res.new_subscription.next_payment_day;

                // 新しいサブスクの要素を用意
                let newSubscription = `
                    <div class="p-4">
                        <a href="${location.origin}/subscriptions/${res.new_subscription.id}">
                            <div class="bg-white p-6 rounded-lg">
                                <h2 class="text-2xl sm:text-4xl font-bold text-pink-500 mb-3">
                                    ${res.new_subscription.title}
                                </h2>
                                <div class="md:flex md:justify-between  sm:gap-x-5">
                                    <div>
                                        <p class="font-black text-gray-400 ">料金</p>
                                        <p class="leading-relaxed text-2xl sm:text-4xl">
                                            ${res.new_subscription.price }円 <span class="text-2xl font-black text-gray-400">/ ${showFrequencyWithSuffix(res.new_subscription.frequency)}</span>
                                        </p>
                                    </div>

                                    <div>
                                        ${res.new_subscription.cancel_day === null ?
                                            `<p class="leading-relaxed text-lg">
                                                <span class="font-black text-gray-400">支払日：</span>
                                                ${res.new_subscription.next_payment_day ? res.new_subscription.next_payment_day.substring(0, 10) : res.new_subscription.first_payment_day.substring(0, 10)}
                                            </p>` :
                                            `<p class="leading-relaxed text-lg">
                                                <span class="font-black text-gray-400">支払日：</span>
                                                --/--/--
                                            </p>`
                                        }
                                        <p class="leading-relaxed text-lg">
                                            <span class="font-black text-gray-400">支払回数：</span>
                                            ${res.new_subscription.number_of_payments}回
                                        </p>
                                    </div>
                                    <div>
                                        <p class="leading-relaxed text-lg">
                                            <span class="font-black text-gray-400">ステータス：</span>
                                            ${res.new_subscription.cancel_day === null ?
                                                `<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-pink-500 text-white">
                                                    契約中
                                                </span>` :
                                                `<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-500 text-white">
                                                    解約済
                                                </span>`
                                            }
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>
                `;
                $('#index-flame').prepend(newSubscription);
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

        // 新規作成時、支払い頻度に末尾の単位をつけて表示
        function showFrequencyWithSuffix(frequency){
            let frequency_with_suffix = "";
            if(frequency === 1 || frequency === 2 || frequency === 3 || frequency === 6 ){
                frequency_with_suffix = frequency + "ヶ月";
            }else{
                frequency_with_suffix = "1年";
            }
            return frequency_with_suffix;
        }

    });
</script>
