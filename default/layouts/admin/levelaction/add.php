<?php
$level = _db()->select('level,id')->from('admin_level')->result();
$menu = _db()->select('*')->from('admin_menu')->result();
$menuTree = treefy($menu);
?>

<form id="levelactionAddForm" role="form" method="post" action="{url /admin_levelaction/addPost}">
    <input type="hidden" name="id" value="" />

    <div class="form-group col-xs-12">
        <div class="col-xs-2">
            <label for="group_question">Chọn nhóm người dùng</label><br />
        </div>
        <div class="col-xs-4">
            <select id="admin_level_id" name="admin_level_id" class="form-control input-sm">
                <option value="">-- Nhóm Người dùng --</option>
                {each $level as $item}
                    <option value="{item[id]}">{item[level]}</option>
                {/each}

            </select>
            <input id="admin_level" type="hidden" name="admin_level" />
        </div>
    </div>

    <div class="form-group col-xs-12">
        <div class="col-xs-2">
            <label for="group_question">Chọn menu</label><br />
        </div>
        <div class="col-xs-4">
            <select id="admin_action" name="admin_action" class="form-control input-sm">
                <option value="">-- Chọn menu --</option>
                {each $menuTree as $cat}
                <option value="{cat[admin_controller]}"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $cat['level']);?>{cat[name]}</option>
                {/each}

            </select>
        </div>
    </div>

    <div class="form-group col-xs-12">
        <div class="col-xs-2">
            <label for="group_question">Chọn action cho quyền truy cập</label><br />
        </div>
        <div class="col-xs-4">
           <div class="showlevel"></div>
        </div>
    </div>

    <div class="form-group col-xs-12">
        <div class="col-xs-2">
            <label for="group_question">Trạng thái</label><br />
        </div>
        <div class="col-xs-4">
            <select class="form-control" id="status" name="status" placeholder="Chưa kích hoạt">
                <option value="0">Chưa kích hoạt</option>
                <option value="1">Đã kích hoạt</option>
            </select>
        </div>
    </div>


    <div class="form-group col-xs-12">
        <div class="col-xs-3 col-xs-offset-2">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span>Thêm</button>
            <a class="btn btn-default margin-left-10" href="{url /admin_levelaction/index}">Hủy</a>
        </div>
    </div>
</form>
<?php
$addValidator = json_encode(pzk_controller()->addValidator);
?>
<script>
    $('#levelactionAddForm').validate({addValidator});
    $('#admin_level_id').change(function() {
        var optionSelected = $(this).find("option:selected");
        var namelevel   = optionSelected.text().trim();
        $('#admin_level').val(namelevel);
    });
    $('#admin_action').change(function() {
        adminController = $(this).val();
        if(adminController.length > 0 ) {
            $.ajax({
                type: "POST",
                url: "{url}/admin_levelaction/getAdminAction",
                data:{adminController:adminController},
                success: function(data) {
                    $('.showlevel').html(data);

                }
            });
        }else {
            alert('Bạn phải chọn menu!');
        }

    });
</script>