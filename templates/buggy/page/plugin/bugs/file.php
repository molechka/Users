<div>
    <h2>Повысить качество данных</h2>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a class="toogle" href="#fromfile" aria-controls="fromfile" role="tab" data-toggle="tab">Из файла</a></li>
    <li role="presentation"><a class="toogle" href="#frompeople" aria-controls="frompeople" role="tab" data-toggle="tab">По одному человеку</a></li>
 
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="fromfile">
      <div class="row">
          <p>Чтобы начать обработку, выберите файл
или перетащите его на выделенную область</p>
     
 
    <div class="row preview_result"></div>
</div>  
          <div class="row">
              <div class="col-md-6">
                 <div class="superup row" ><img  src="/tmp/files//drag.png"></div>    
              </div>
              <div class="col-md-4">
                  <p><a href="#"  class="btn btn-danger clickfile">Выбрать файл</a></p>
                  <p>Поддерживаются файлы Excel и CSV до 10 Мб.</p>
                  <p>Просмотр 100 записей — бесплатно.</p>
                  <p><a href="/tmp/йа_примерчик.xlsx">Скачать пример для обработки</a></p>
              </div>
          </div>
          
      </div>
      <div role="tabpanel" class="tab-pane" id="frompeople">
          <?
          echo $controller->render("form",array());
          ?>
      </div>
    
  </div>

</div>

