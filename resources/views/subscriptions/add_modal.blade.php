<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="post" id="addSubscriptionForm">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">サブスク登録</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="errMsgContainer mb-3"></div>
                    <div id="ajax-flash-message"></div>

                    <div class="form-group">
                        <label for="title" class="form-label">名前</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="サブスク名を入力…">
                    </div>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />

                    <div class="form-group">
                        <label for="price" class="form-label">料金</label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="サブスク料金を入力…">
                    </div>
                    <div class="form-group">
                        <label for="first_payment_day" class="form-label">初回支払日</label>
                        <input type="date" class="form-control" name="first_payment_day" id="first_payment_day">
                    </div>
                    <div class="form-group">
                        <label for="frequency" class="form-label">支払い頻度</label>
                        <select class="form-control" name="frequency" id="frequency">
                            <option value="1">月に1回</option>
                            <option value="2">2ヶ月に1回</option>
                            <option value="3">3ヶ月に1回</option>
                            <option value="6">6ヶ月に1回</option>
                            <option value="12">1年に1回</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="url" class="form-label">URL</label>
                        <input type="url" class="form-control" name="url" id="url" placeholder="https://sample...">
                    <div class="form-group">
                        <label for="memo" class="form-label">メモ</label>
                        <textarea class="form-control" name="memo" id="memo" placeholder="メモを入力…"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-primary add_subscription">保存する</button>
                </div>
            </div>
        </div>
    </form>
</div>
