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
                $('#index-flame').prepend('<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"><a href="'+ location.href + '/' + res.new_subscription.id +'"'+'><div class="p-6 text-gray-900">'
                    +res.new_subscription.title+'<br>'+res.new_subscription.price+'<br>'+res.new_subscription.frequency+'<br>'+res.new_subscription.first_payment_day+'<br>'+res.new_subscription.url+'<br>'+res.new_subscription.memo+
                    '</div></a></div>');
            }).fail(function(){
                alert('通信の失敗をしました');
            });
        })
    });
</script>
