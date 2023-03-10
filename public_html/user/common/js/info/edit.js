var adOffset, adSize, winH;
// $(window).on('load resize',function(){
//     adOffset = $('#blockWork').offset().top;
//     winH = $(window).height();
// });

var sortable_option = {
    items:'div.first-dir',
    placeholder: 'ui-state-highlight',
    opacity: 0.7,
    handle:'div.sort_handle2',
    connectWith: '.list_table_sub',
    update: function(e, obj) {

    }
};

var sortable_option_sub = {
    items:'div.first-dir',
    placeholder: 'ui-state-highlight',
    opacity: 0.7,
    handle:'div.sort_handle2',
    connectWith: '.list_table, .list_table_sub',
    receive: function(e, obj) {
      var waku_block_type = $(this).data('wakuBlockType');
      var section_no = $(this).closest('.editor__table').data('sectionNo');
      Object.keys(out_waku_list).forEach(function (k) {
          if (waku_block_type == k) {
            for(let i in out_waku_list[k]) {
              if ($(obj.item['0']).find('input.block_type').val() == out_waku_list[k][i]) {
                if (obj.sender !== null) {
                  $(obj.sender[0]).sortable('cancel');
                }
                return false;
              }
            }
          }
        });
    },
    update: function(e, obj) {
      var section_no =$(obj.item['0']).closest('.editor__table').data('sectionNo');
      console.log(section_no);
      if (typeof section_no !== 'undefined') {
        var waku_block_type = $(obj.item['0'].closest('.editor__table')).data('blockType');
        $(obj.item['0']).find('input.section_no').val(section_no);
      } else if (obj.sender == null) {
        $(obj.item['0']).find('input.section_no').val(0);
      }
    }
};

var sortable_option_relation = {
    items:'div.relation-dir',
    placeholder: 'ui-state-highlight',
    opacity: 0.7,
    handle:'div.sort_handle2',
    receive: function(e, obj) {
      var waku_block_type = $(this).data('wakuBlockType');
      var section_no = $(this).closest('.editor__table').data('sectionNo');
      Object.keys(out_waku_list).forEach(function (k) {
          if (waku_block_type == k) {
            for(let i in out_waku_list[k]) {
              if ($(obj.item['0']).find('input.block_type').val() == out_waku_list[k][i]) {
                if (obj.sender !== null) {
                  $(obj.sender[0]).sortable('cancel');
                }
                return false;
              }
            }
          }
        });
    },
    update: function(e, obj) {

    }
};

function addTag(tag) {
  var url = '/user_admin/infos/add_tag';
  var csrf = $('input[name="_csrfToken"]').val();
  var params = {
    'num' : tag_num,
    'tag' : tag
  };

  $.ajax(url,{
      type: "post",
      data: params,
      beforeSend: function(xhr) {
          xhr.setRequestHeader('X-CSRF-Token', csrf);
        },
      success: function(a) {
          $("#tagArea").append(a);
          tag_num++;
      }
  });
}

function addBlock(type) {
  var url = '/user_admin/infos/add_row';
  var csrf = $('input[name="_csrfToken"]').val();
  var params = {
    'rownum':rownum,
    'block_type' : type
  };
  if (rownum >= max_row) {
    alert_dlg(`??????????????????????????????${max_row}??????????????????`);
    return;
  }
  $.ajax(url, {
      type: "post",
      data: params,
      beforeSend: function(xhr) {
          xhr.setRequestHeader('X-CSRF-Token', csrf);
          },
      success: function(a) {
        $("#blockArea").append(a);
        if (type == 2 || type == 11) {
          var elm = `#block_no_${rownum} textarea.editor`;
          setWysiwyg(elm);
        }

        if (type == 13) {
          $(`#block_no_${rownum} .list_table_relation`).sortable(sortable_option_relation);
        }
        else if (type in block_type_waku_list !== false) {
          $(`#block_no_${rownum} .list_table_sub`).sortable(sortable_option_sub);
        }

        rownum++;

        // adOffset = $('#blockWork').offset().top;
        // winH = $(window).height();


      }
  });
}

// ???????????????????????????????????????
function addBlockRelation(waku_no, section_no) {
  var type = block_type_relation;
  var url = '/user_admin/infos/add_row';
  var csrf = $('input[name="_csrfToken"]').val();
  var params = {
    'rownum':rownum,
    'block_type' : type,
    'section_no' : section_no
  };

  if (rownum >= max_row) {
    alert_dlg(`??????????????????????????????${max_row}??????????????????`);
    return;
  }

  $.ajax(url,{
      type: "post",
      data: params,
      beforeSend: function(xhr) {
          xhr.setRequestHeader('X-CSRF-Token', csrf);
        },
      success: function(a) {
          $(`#block_no_${waku_no} .list_table_relation`).append(a);

          rownum++;
      }
  });
}

function changeStyle(elm, rownum, target_class, target_name) {
  var class_name = $(elm).val();

  $(`#block_no_${rownum} .${target_class}`).removeClass(function(index, className){
    var match = new RegExp("\\b" + target_name + "\\S+","g");
    return (className.match(match) || []).join(' ');
  });

  if (class_name != "") { 
    if (class_name.match(/^[0-9]+$/)) {
      class_name = target_name + class_name;
    }
    $(`#block_no_${rownum} .${target_class}`).addClass(class_name);
  }

  var type = $(elm).closest('tbody.list_table_sub').data('wakuBlockType');
  if (type in block_type_waku_list !== false) {
      if (class_name == 'waku_style_6') {
        $(`#block_no_${rownum} .optionValue3`).attr('disabled', true);
        $(`#block_no_${rownum} .optionValue3`).val('');
      } else {
        // $(`#block_no_${rownum} .optionValue2`).attr('disabled', false);
        $(`#block_no_${rownum} .optionValue3`).attr('disabled', false);
      }
    }
}

function changeSelectStyle(elm, rownum) {
  var style = $(elm).val();
  // console.log(style);
  if (style == 'waku_style_6') {
    $("#idWakuColorCol_" + rownum).hide();
    $("#idWakuColorCol_" + rownum + ' select').attr("disabled", true);
    $("#idWakuBgColorCol_" + rownum ).show();
    $("#idWakuBgColorCol_" + rownum + ' select').attr("disabled", false);
  } else {
    $("#idWakuBgColorCol_" + rownum ).hide();
    $("#idWakuBgColorCol_" + rownum + ' select').attr("disabled", true);
    $("#idWakuColorCol_" + rownum).show();
    $("#idWakuColorCol_" + rownum + ' select').attr("disabled", false);
  }
}

function changeWidth(elm, rownum, target_class, name) {
  var num = $(elm).val();

  if (num > 0) {
    $(`#block_no_${rownum} .${target_class}`).css(name, `${num}px`);
  } else {
    $(`#block_no_${rownum} .${target_class}`).css(name, ``);
    num = '';
    $(elm).val(num);
  }
}
function getFileSize(e) {

    var file = e.files[0];

    if (typeof file === 'undefined') {
      return 0;
    }
    if (file.length == 0) {
      return 0;
    }

    var reader = new FileReader();

    if (file.size > max_file_size) {
        alert_dlg('????????????????????????????????????????????????????????????????????????');
        $(e).val('');
        return 0;
    }

    return file.size;
}

function changeButtonName(elm) {
  var row = $(elm).data("row");
  $("#idButtonTitle_" + row).html($(elm).val());
}

function changeButtonColor(elm) {
  var row = $(elm).data('row');
  var btn = $("#idButtonTitle_" + row);

  btn.removeClass('btn-primary');
  btn.removeClass(function (index, className) {
    return (className.match(/\bbutton_color_\S+/g) || []).join(' ');
  });
  btn.addClass($(elm).val());

}

function changeFileName(elm, row) {
  var name_block = $("#block_no_" + row).find('.result > span');
  name_block.text($(elm).val());
}

function clickSort(row, mode) {
  var item = $("#block_no_" + row);
  var section_no = item.find('.section_no').val();
  var wakuId = '#wakuId_' + section_no;
  if (section_no == 0) {
    wakuId = '#blockArea';
  }

  if (mode == 'up') {
    item.prev().before(item);
  } else if (mode == 'down') {
    item.next().after(item);
  } else if (mode == 'first') {
    $(wakuId + ' .item_block:first').before(item);
  } else if (mode == 'last') {
    $(wakuId).append(item);
  }
}

function clickItemConfig(elm) {
  var section_no = $(elm).closest('.item_block').find('.section_no').val();
  var wakuId = '#wakuId_' + section_no;
  if (section_no == 0) {
    wakuId = '#blockArea';
  }

  var type = $(elm).closest('.item_block').find('.block_type').val();
  if (type in block_type_waku_list !== false) {
    wakuId = '#blockArea';
  }  

  // ???????????????
  if ($(wakuId).find('> .item_block:first').attr('id') == $(elm).closest('.item_block').attr('id')) {
    $(elm).next().find('.up').hide();
  } else {
    $(elm).next().find('.up').show();
  }

  // ???????????????
  if ($(wakuId).find('> .item_block:last').attr('id') == $(elm).closest('.item_block').attr('id')) {
    $(elm).next().find('.down').hide();
  } else {
    $(elm).next().find('.down').show();
  }
}

$(function () {
    rownum = $("#idContentCount").val();

    // ????????????????????????????????????
    $(window).scroll(function () {
        if ($(this).scrollTop() > adOffset - winH) {
            $("#editBtnBlock").removeClass('fixed-bottom');
            $("#editBtnBlock").removeClass('pb-3');
        } else {

            $("#editBtnBlock").addClass('fixed-bottom');
            $("#editBtnBlock").addClass('pb-3');
        }
    });

    $("body").on('change', '.attaches', function() {
//       var id = $(this).attr('id');
// console.log(id);
//       var ele = document.getElementById(id);
// console.log(ele);
//       var size = getFileSize(document.getElementById(id));
//       if (size > max_file_size) {
//         alert_dlg('????????????????????????????????????????????????????????????????????????');
//         $(this).val('');
//       }

      var attaches = document.getElementsByClassName('attaches');
      form_file_size = 0;
      for (var i = 0; i < attaches.length; i++) {
        form_file_size += getFileSize(attaches[i]);
      }  

      if (form_file_size > total_max_size) {
        $(this).val('');
        alert_dlg('????????????????????????????????????????????????????????????????????????????????????');
        return;
      }

      if ($(this).hasClass('image')) {
        var reader = new FileReader();
        var btn = this;
        $(btn).closest('label').find('.thumbnail').html('<div><i class="fas fa-plus"></i> <i class="far fa-image"></i></div>');
        reader.onload = function () {
          var img_src = $('<img>').attr('src', reader.result).css({'max-width':'500px', 'max-height': '400px'});
          $(btn).closest('label').find('.thumbnail').append(img_src);
        }
        // console.log($(this).prop('files'));
        reader.readAsDataURL($(this).prop('files')[0]);
      } else if ($(this).hasClass('file')) {
        $(this).closest('label').find('.result').html('');
        var input = $(this).prop('files')[0];
        $(this).closest('label').find('.result').append(input.name);
  
      }
      // console.log(form_file_size);
    });

    

  // ????????????
    $(".list_table").sortable(sortable_option);
    $(`.list_table_sub`).sortable(sortable_option_sub);
    $(`.list_table_relation`).sortable(sortable_option_relation);


    // ??????????????????
    $('body #blockArea').on('click', '.btn_list_delete', function(){
        var row = $(this).data("row");
        var block_id = $(`#idBlockId_${row}`).val();

        $(`#block_no_${row} input, #block_no_${row} textarea, #block_no_${row} select`).attr('disabled', true);
        $(`#block_no_${row}`).addClass('delete');
        $(this).html('????????????');
        $(this).removeClass('btn_list_delete');
        $(this).removeClass('btn-secondary');
        $(this).addClass('btn_list_undo');
        $(this).addClass('btn-danger');


        if (block_id > 0) {
          var html = `<input type="hidden" name="delete_ids[]" value="${block_id}" id="delBlock_${block_id}">`;
          $("#deleteArea").append(html);
        }
    });

    // ?????????????????????
    $('body #blockArea').on('click', '.btn_list_undo', function(){
        var row = $(this).data("row");
        var block_id = $(`#idBlockId_${row}`).val();

        $(`#block_no_${row} input, #block_no_${row} textarea, #block_no_${row} select`).attr('disabled', false);
        $(`#block_no_${row}`).removeClass('delete');
        $(this).html('??????');
        $(this).removeClass('btn_list_undo');
        $(this).removeClass('btn-danger');
        $(this).addClass('btn_list_delete');
        $(this).addClass('btn-secondary');


        if (block_id > 0) {
          $(`#deleteArea #delBlock_${block_id}`).remove();
        }
    });

    // ????????????
    $('#btnAddTag').on('click', function() {
      var tag = $("#idAddTag").val();
      if (tag != "") {
        addTag(tag);
        $("#idAddTag").val('');
      } else {
        alert_dlg('?????????????????????????????????');
      }
      return false;
    });

    // ????????????
    $("#tagArea").on('click', '.delete_tag', function() {
      var id = $(this).data('id');
      $("#tag_id_" + id).addClass('delete');
      $("#tag_id_" + id + ' input').attr('disabled', true);
      $("#tag_id_" + id + ' a').removeClass('delete_tag');
      $("#tag_id_" + id + ' a').addClass('delete_rollbak');
    });

    // ??????????????????
    $("#tagArea").on('click', '.delete_rollbak', function() {
      var id = $(this).data('id');
      $("#tag_id_" + id).removeClass('delete');
      $("#tag_id_" + id + ' input').attr('disabled', false);
      $("#tag_id_" + id + ' a').removeClass('delete_rollbak');
      $("#tag_id_" + id + ' a').addClass('delete_tag');
    });

    // ???????????????
    $("#btnListTag").on('click', function() {
      pop_box.select = function(tag) {
        addTag(tag);
        pop_box.close();
      };

      pop_box.open({
            element: "#btnListTag",
            href: "/user_admin/infos/pop_taglist?page_config_id=" + page_config_id,
            open: true,
            onComplete: function(){
            },
            onClosed: function() {
                pop_box.remove();
            },
            opacity: 0.5,
            iframe: true,
            width: '900px',
            height: '750px'
          });

          return false;
    })

    $("body").on('click', '.pop_image_single', function(){
        pop_box.image_single();
    });

    $("#btnSave").on('click', function() {
      $("#idPostMode").val('save');
      $(this).closest('form').removeAttr('target');
      document.fm.submit();
      return false;
    });

    // $("#btnPreview").on('click', function() {
    //   $("#idPostMode").val('preview');
    //   $(this).closest('form').attr('target', "_blank");
    //   document.fm.submit();
    //   return false;
    // });

    // ckeditor??????????????????????????????????????????????????????????????????
    var elements = $('textarea.editor');
    $.each(elements, function(key, value) {
      var parent_id = $(value).attr('id');
      // ckeditor
      setWysiwyg('#' + parent_id);
    });
});
