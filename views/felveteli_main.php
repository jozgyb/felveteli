<script type="text/javascript" src="../../felveteli/js/db_ajax.js"></script>
<form method="post" id="ajaxForm">
    <div class="row">
        <div class="form-floating mt-3 col-lg-2 mx-auto">
            <input class="form-control" list="kepzesDataList" id="kepzes" name="kepzes">
            <label class="form-label" for="kepzes">Képzés:</label>
            <datalist id="kepzesDataList">
            </datalist>
        </div>
    </div>
    <div class="row">
        <div class="form-floating mt-3 col-lg-2 mx-auto">
            <input class="form-control" list="nemDataList" id="nem" name="nem">
            <label class="form-label" for="nem">Nem:</label>
            <datalist id="nemDataList">
            </datalist>
        </div>
    </div>
    <div class="row">
        <div class="form-floating mt-3 col-lg-2 mx-auto">
            <input class="form-control" list="sorrendDataList" id="sorrend" name="sorrend">
            <label class="form-label" for="sorrend">Sorrend:</label>
            <datalist id="sorrendDataList">
            </datalist>
        </div>
    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary mx-auto col-lg-1 mt-3 mb-3">Keresés</button>
    </div>
</form>