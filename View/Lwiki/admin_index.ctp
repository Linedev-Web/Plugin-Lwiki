<style>
    .box-col-header {
        font-weight: bold;
        margin-left: -30px;
    }

    form,
    a[data-toggle="collapse"] {
        display: inline-block;
        vertical-align: middle;
    }

    form {
        width: 90%;
    }

    .float-right {
        float: right;
    }

    a[data-toggle="collapse"] {
        transition: transform 0.25s ease;
        transform: rotate(-180deg);
        color: #000;
    }

    a[data-toggle="collapse"].collapsed {
        transform: rotate(0deg);
    }

    .box-col-header .box-title {
        font-weight: bold;
    }

    .ui-sortable-helper {
        left: 45px !important;
    }

    .col--category,
    .col--item {
        border-left: 2px solid rgba(190, 190, 190, 0.56);
        padding-left: 50px;
    }

    .col--type {
    }

    .col--category {
    }

    .col--item {
    }

    .col--drag-type,
    .col--drag-category,
    .col--drag-item {
        position: relative
    }

    .col--drag-type blockquote,
    .col--drag-category blockquote,
    .col--drag-item blockquote {
        background-color: #fdfdfd;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        margin: 1rem 0;
        padding: 1rem 15px;
        border-radius: 8px;
        width: 100%;
    }


    .col--drag-type {
        border-bottom: 2px solid rgba(190, 190, 190, 0.56);
        margin-bottom: 10rem;
    }

    .col--drag-category {
        margin-bottom: 5rem;
    }

    .col--drag-item {
    }

    .fa-arrows {
        font-size: 20px;
        cursor: pointer
    }

    .icon {
        height: 45px;
        line-height: 45px;
        text-align: center;
        display: inline-block;
        width: 45px;
        position: absolute;
        top: 10px;
        left: -45px
    }

    .wiki button {
        background-color: transparent;
        border: 0;
        padding: 0;
        border-radius: 10px;
    }

    .icon--custom {
        margin: 0 0.3em;
    }

    .icon--custom .fa {
        color: #fff;
        background-color: #00a65a;
        text-align: center;
        border-radius: 10px;
        display: inline-block;
        height: 40px;
        width: 40px;
        line-height: 40px;
        cursor: pointer;
    }

    .icon--custom .fa-pencil {
        background-color: #1976d2;

    }

    .icon--custom .fa-trash-o {
        background-color: #d32f2f;
    }

    .icon--custom .fa-chevron-down {
        background-color: #d2d2d2;
    }
</style>
<section class="container wiki">
    <div class="row">
        <div class="col-md-12 col--type" id="sortable">
            <div class="box-header box-col-header">
                <i class="fa fa-folder"></i>
                <h3 class="box-title">Ajouter une catégorie</h3>
            </div>
            <form action="" class="form-inline" method="post" data-ajax="true"
                  data-redirect-url="<?= $this->Html->url(array('controller' => 'lwiki', 'action' => 'index', 'admin' => true)) ?>">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" required/>
                </div>
                <div class="form-group">
                    <button type="submit" class="icon--custom">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
            <?php $t = -1;
            foreach ($types as $key => $type): $i++ ?>
                <div class="col--drag-type" id="accordion">
                    <?php if (count($type["Ltypes"]) > 1) { ?>
                        <div class="icon">
                            <i class="fa fa-arrows"></i>
                        </div>
                    <?php } ?>
                    <blockquote>
                        <form action="<?= $this->Html->url(array('controller' => 'Lwiki', 'action' => 'edit_types', 'plugin' => 'lwiki', 'admin' => true)) ?>"
                              data-redirect-url="<?= $this->Html->url(array('controller' => 'Lwiki', 'action' => 'index', 'plugin' => 'lwiki', 'admin' => true)) ?>"
                              method="post" data-ajax="true" class="form-inline">
                            <div class="form-group">
                                <input class="form-control transparent-input" name="name"
                                       type="text"
                                       value="<?= $type["Ltypes"]["name"] ?>"/>
                                <input type="hidden" name="id" value="<?= $type["Ltypes"]["id"] ?>">
                            </div>
                            <div class="form-group float-right">
                                <button type="submit" class="icon--custom">
                                    <i class="fa fa-pencil"></i>
                                    <button>
                                        <a onclick="confirmDel('<?= $this->Html->url(array('controller' => 'lwiki', 'action' => 'delete/' . $type['Ltypes']['id'], 'plugin' => 'lwiki', 'admin' => true)) ?>')"
                                           class="icon--custom">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                            </div>
                        </form>
                        <a class="icon--custom" data-toggle="collapse" data-parent="#accordion"
                           href="#collapse-type-<?= $type["Ltypes"]["id"] ?>">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </blockquote>

                    <div id="collapse-type-<?= $type["Ltypes"]["id"] ?>" class="panel-collapse collapse in">
                        <div class="col--category">
                            <div class="box-header box-col-header">
                                <i class="fa fa-folder-open"></i>
                                <h3 class="box-title">Ajouter une sous-catégorie</h3>
                            </div>
                            <form action="<?= $this->Html->url(array('controller' => 'Lwiki', 'action' => 'add_category')) ?>"
                                  data-redirect-url="<?= $this->Html->url(array('controller' => 'lwiki', 'action' => 'index', 'admin' => true)) ?>"
                                  method="post" data-upload-image="true" data-ajax="true"
                                  class="form-inline">
                                <div class="form-group">
                                    <input class="form-control" type="text" id="name" name="name" required>
                                    <input class="form-control" type="hidden" id="type" name="type"
                                           value="<?= $type["Ltypes"]["id"] ?>">
                                </div>
                                <div class="form-group">
                                    <button class="icon--custom" type="submit">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </form>
                            <?php $c = -1;
                            foreach ($type['Lcategory'] as $key2 => $category): $c++ ?>
                                <!--                                --><? //= var_dump($type['Lcategory'][$c]) ?>
                                <div class="col--drag-category" id="<?= $category['name'] ?>-<?= $c ?>">
                                    <?php if (count($type['Lcategory'][$c]) > 1) { ?>
                                        <div class="icon">
                                            <i class="fa fa-arrows"></i>
                                        </div>
                                    <?php } ?>
                                    <blockquote>
                                        <form action="<?= $this->Html->url(array('controller' => 'Lwiki', 'action' => 'edit_category', 'plugin' => 'lwiki', 'admin' => true)) ?>"
                                              data-redirect-url="<?= $this->Html->url(array('controller' => 'Lwiki', 'action' => 'index', 'plugin' => 'lwiki', 'admin' => true)) ?>"
                                              method="post" data-ajax="true" class="form-inline">
                                            <div class="form-group">
                                                <input class="form-control" name="name" type="text"
                                                       value="<?= $category["name"] ?>"/>
                                                <input type="hidden" name="id"
                                                       value="<?= $category["id"] ?>">
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" name="type">
                                                    <option value="<?= $category['Ltypes']['id'] ?>"><?= $category['Ltypes']['name'] ?></option>
                                                    <?php foreach ($types as $type): ?>
                                                        <option value="<?= $type["Ltypes"]['id'] ?>"><?= $type["Ltypes"]['name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group float-right">
                                                <button class="icon--custom" type="submit">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <a onclick="confirmDel('<?= $this->Html->url(array('controller' => 'lcategory', 'action' => 'delete/' . $category['id'], 'plugin' => 'lwiki', 'admin' => true)) ?>')"
                                                   class="icon--custom"><i class="fa fa-trash-o"></i></a>
                                            </div>
                                        </form>
                                        <a class="icon--custom" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapse-category-<?= $category["id"] ?>">
                                            <i class="fa fa-chevron-down"></i>
                                        </a>
                                    </blockquote>

                                    <div id="collapse-category-<?= $category["id"] ?>"
                                         class="panel-collapse collapse in">
                                        <div class="col--item">
                                            <div class="box-header box-col-header">
                                                <i class="fa fa-file"></i>
                                                <h3 class="box-title">Ajouter un article</h3>
                                                <a href="<?= $this->Html->url(array('controller' => 'litem', 'action' => 'add/' . $category['id'], 'plugin' => 'lwiki', 'admin' => true)) ?>"
                                                   class="icon--custom">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                            <?php $i = -1;
                                            foreach ($category['Litem'] as $key3 => $item): $i++ ?>

                                                <div class="col--drag-item" id="<?= $item['name'] ?>-<?= $i ?>">
                                                    <?php if (count($category['Litem'][$i]) > 1) { ?>
                                                        <div class="icon">
                                                            <i class="fa fa-arrows"></i>
                                                        </div>
                                                    <?php } ?>
                                                    <blockquote style="display: inline-block">
                                                        <form class="form-inline">
                                                            <div class="form-group">
                                                                <?= $item['name'] ?>
                                                            </div>
                                                            <div class="form-group float-right">
                                                                <a href="<?= $this->Html->url(array('controller' => 'litem', 'action' => 'edit/' . $item['id'], 'plugin' => 'lwiki', 'admin' => true)) ?>"
                                                                   class="icon--custom"><i class="fa fa-pencil"></i>
                                                                </a>
                                                                <a onclick="confirmDel('<?= $this->Html->url(array('controller' => 'litem', 'action' => 'delete/' . $item['id'], 'plugin' => 'lwiki', 'admin' => true)) ?>')"
                                                                   class="icon--custom"><i
                                                                            class="fa fa-trash-o"></i></a>
                                                            </div>
                                                        </form>
                                                    </blockquote>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="ajax-msg"></div>
</section>
<script>
    $(function () {
        $("#sortable").sortable({
            axis: 'y',
            items: '.col--drag-item',
            revert: true,
            start: function (evt, ui) {
                // console.log(this)
            },
            stop: function (event, ui) {
                // offsetParent
                let itemId = $(ui['item'][0]['id'])
                var inputs = {};

                inputs['wiki_item_order'] = $(this).sortable('serialize');
                inputs['wiki_item_id_selected'] = itemId.selector
                inputs['wiki_category_id'] = $(ui['item'][0]['offsetParent']).attr(('id'))
                inputs['data[_Token][key]'] = '<?= $csrfToken ?>';

                $.post("<?= $this->Html->url(array('controller' => 'litem', 'action' => 'save_ajax', 'admin' => true)) ?>", inputs, function (data) {
                    console.log(data)
                    if (data.statut) {
                        $('#save').empty().html('Save');
                    } else if (!data.statut) {
                        $('.ajax-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><i class="icon icon-warning-sign"></i> <b><?= $Lang->get('GLOBAL__ERROR') ?> :</b> ' + data.msg + '</i></div>').fadeIn(500);
                    } else {
                        $('.ajax-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><i class="icon icon-warning-sign"></i> <b><?= $Lang->get('GLOBAL__ERROR') ?> :</b> <?= $Lang->get('ERROR__INTERNAL_ERROR') ?></i></div>');
                    }
                });
            }
        });
    });
</script>