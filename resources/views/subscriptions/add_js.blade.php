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
                success:function(res){
                    if(res.status=='success'){
                        $('#addModal').modal('hide');
                        $('#addSubscriptionForm')[0].reset();
                        $('#subscriptions_index').load(location.href+' #subscriptions_index');
                        console.log(res.status);
                    }
                },error:function(err){
                    let error = err.responseJSON;
                    $.each(error.errors,function(index, value){
                        $('.errMsgContainer').append('<span class="text-danger">'+value+'</span>'+'<br>');
                    });
                }
            });
        })

        // subscription更新
        $(document).on('click', '.update_subscription_form', function(){
            let subscription = $(this).data('subscription');
            // let name = $(this).data('title');
            // let price = $(this).data('price');

            // $('#up_id').val(id);
            $('#up_title').val(subscription.title);
            $('#up_price').val(subscription.price);
            $("#up_frequency option[value="+subscription.frequency+"]").prop('selected', true);
            $('#up_first_payment_day').val(subscription.first_payment_day.slice(0,10));
            $('#up_url').val(subscription.url);
            $('#up_memo').val(subscription.memo);

            console.log(subscription);
            console.log(subscription.frequency);
            console.log($.type(subscription.frequency));
        });
    });
</script>
