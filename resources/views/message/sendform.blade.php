<div class="row" id="mymodal">
<form action="/message" method="post">
    {{csrf_field()}}
    <div class="form-group">
        <label for="mobile">شماره موبایل</label>
        <input type="text"  name="mobile" class="form-control" id="mobile">
    </div>

    <div class="form-group">
        <label for="message">پیام</label>
        <textarea  class="form-control" name="message" id="message"></textarea>
    </div>


    <button type="submit" class="btn btn-info">ارسال</button>
</form>
</div>