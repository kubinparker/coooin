function ajax_get(url, method, params, success) {
    var data = null;
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.onload = function(event) {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                data = JSON.parse(xhr.responseText);
                success(data);
            } else {
                console.log(xhr.statusText);
            }
        }
    };
    xhr.onerror = function(event) {
        console.log(event.type);
    };

    if (method == 'GET') {
        xhr.send(null);
    } else {
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send( EncodeHTMLForm(params));
    }

  return data;
}
function convertHtmlForm(data) {
    var params = [];

    for (var val in data) {
        params[data[val].name] = data[val].value;
    }
    return params;
}
function EncodeHTMLForm( data )
{
    var params = [];

    for( var name in data )
    {
        var value = data[ name ];
        var param = encodeURIComponent( name ) + '=' + encodeURIComponent( value );

        params.push( param );
    }

    return params.join( '&' ).replace( /%20/g, '+' );
}
function alert_dlg(message, options) {
    var buttons = [
        {
          text:'はい',
          click: function(){
            $(this).dialog("close");
          }
        }
    ];

    if (typeof options !== 'undefined') {
        if (typeof options.buttons !== 'undefined') {
            buttons = options.buttons;
        }
    }
    $("#kakunin_dialog").dialog({
        autoOpen:false,
        width:300,
        modal: true,
        buttons: buttons
    });
    $("#kakunin_dialog p").html(message);
    $("#kakunin_dialog").dialog("open");
}

function camelCase(str){
  str = str.charAt(0).toLowerCase() + str.slice(1);
  return str.replace(/[-_](.)/g, function(match, group1) {
      return group1.toUpperCase();
  });
}

function pascalCase(str){
  var camel = camelCase(str);
  return camel.charAt(0).toUpperCase() + camel.slice(1);
}

function submitSupport(elm) {
  var $form = $("#FmSupportPopup");
  if (typeof elm != 'undefined') {
    $('#idUuid').val($(elm).data('item'));
  }
  var params = $form.serializeArray();
  params = convertHtmlForm(params);
  ajax_get('/v1/item/on_like.json','post', params, function(a) {
    if (a.error.code == 0) { // 成功時
      if (a.result.is_valid == 0) { // エラー時
        $.each(a.result.form, function(key, value) {
          if (value.error == 1) {
            $("#idSupport" + pascalCase(key)).addClass('error');
            $("#idSupportError" + pascalCase(key)).text(value.message);
          } else {
            $("#idSupport" + pascalCase(key)).removeClass('error');
            $("#idSupportError" + pascalCase(key)).text('');
          }
        });
      } else{
        if (a.result.is_new == 1) {
          window.location.reload();
          return false;
        } else {
          $.post('/item/ajax-support-on-like', {uuid:params.uuid}, function(b) {
            $('.ProductItemBody_' + params.uuid).html(b);
          });
        }
      }
    }
  });
  return false;
}

function setSupportItem(elm) {
  $('#idUuid').val($(elm).data('item'));
  $('#idSupportName').removeClass('error');
  $('#idSupportErrorName').text('');
  $('#idSupportEmail').removeClass('error');
  $('#idSupportErrorEmail').text('');
  return false;
}