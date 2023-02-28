      <template id="block">
        <div id="" class="row block rounded rounded-lg mb-4">
          <div class="col-12 block-header pinned rounded-top rounded-lg alert-contact py-3 mb-4">
            <div class="row">
              <div class="col-lg-5 mb-1 mb-xl-0"><input id="" type="text" class="form-control block-name" name="" placeholder="Nom du bloc" value="" /></div>
              <div class="col-lg-7 mb-1 mb-lg-0 text-left">
                <button class="add-item btn btn-success" name="">Ajouter produit</button>
                <button class="delete-block btn btn-danger" name="">Suppr. bloc</button>
                <button class="clone-block btn btn-light" name="">Cloner</button>
              </div>
            </div>
          </div>
        </div>
      </template>
      
      <template id="item">
        <div id="" class="col-lg-6 block-data item pb-3">
          <div class="row px-3 pb-3">
            <div class="col-md-2 col-lg-2 m-0 align-self-center"><button class="delete-item btn btn-outline-danger" name="">X</div>
            <div><input type="hidden" class="form-control item-id" name="" value="" readonly="readonly" /></div>
            <div class="col-md-3 col-lg-6 my-0 p-1"><input type="text" class="form-control item-name" name="" placeholder="Nom du produit" value="" /></div>
            <div class="col-md-3 col-lg-4 my-0 p-1"><input type="number" class="form-control item-price" name="" placeholder="00.00" min="0.00" max="1000.00" step=0.01 value="" /></div>
            <div class="col-md-4 col-lg-10 offset-lg-2 my-0 p-1">
              <select id="" class="form-control item-image" name="">
                <?php $list = array_diff(scandir("../img/icons"), array("index.html", "..")); foreach($list as $value) { echo "<option value=\"$value\">$value</option>"; } ?>
              </select>
            </div>
            <div class="col-md-10 offset-md-2 my-0 p-1"><input type="text" class="form-control item-description" name="" placeholder="Description" value="" /></div>
          </div>
        </div>
      </template>