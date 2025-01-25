<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <form action="" method="post" id="updateSubscriptionForm">
        @csrf
        {{-- <input type='hidden' id="{{ Auth::user()->id }}" name="up_user_id"> --}}
        <input type='hidden' id="{{ $subscription->id }}" name="up_id">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">サブスク更新</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- エラーメッセージ --}}
                    <div class="errMsgContainer mb-3">
                    </div>

                    <div class="form-group">
                        <label for="up_title" class="form-label">名前</label>
                        <input type="text" class="form-control" name="up_title" id="up_title" placeholder="サブスク名を入力…">
                    </div>
                    <div class="form-group">
                        <label for="up_price" class="form-label">料金</label>
                        <input type="number" class="form-control" name="up_price" id="up_price" placeholder="サブスク料金を入力…">
                    </div>
                    <div class="form-group">
                        <label for="up_first_payment_day" class="form-label">初回支払日</label>
                        <input type="date" class="form-control" name="up_first_payment_day" id="up_first_payment_day">
                    </div>
                    <div class="form-group">
                        <label for="up_frequency" class="form-label">支払い頻度</label>
                        <select class="form-control" name="up_frequency" id="up_frequency">
                            <option value="1">月に1回</option>
                            <option value="2">2ヶ月に1回</option>
                            <option value="3">3ヶ月に1回</option>
                            <option value="6">6ヶ月に1回</option>
                            <option value="12">1年に1回</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="up_url" class="form-label">URL</label>
                        <input type="url" class="form-control" name="up_url" id="up_url" placeholder="https://sample...">
                    </div>
                    <div class="form-group">
                        <label for="up_memo" class="form-label">メモ</label>
                        <textarea class="form-control" name="up_memo" id="up_memo" placeholder="メモを入力…"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-primary update_subscription">更新する</button>
                </div>
            </div>
        </div>
    </form>
</div>
