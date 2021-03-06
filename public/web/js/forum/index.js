/*---------------------------------------------------------------------------------------
 index.js 首页
 ---------------------------------------------------------------------------------------*/

$(function(){
    // 点赞 取消点赞
    $('.forum-index .rankings-btn').on('click', function () {
        var obj = this;
        // 点赞操作
        if(!$(this).hasClass('fa-heart')){
            $(this).removeClass('fa-heart-o').addClass('fa-heart');
            $.ajax({
                type: 'post',
                url: '/web/ranking',
                data: {
                    user_id: $(this).data('uid'),
                    discussion_id: $(this).data('did'),
                },
                dataType: 'json',
                beforeSend: function (xhr) {
                    layer.load(1, {shade: [0.1,'#000']});
                },
                success: function(res, status, xhr){
                    if(status == 'success'){
                        if(res.ServerNo == 'SN000'){
                            layer.alert('点赞成功');
                        }else{
                            layer.alert(res.ResultData);
                        }
                    }
                },
                error: function(xhr, status, errorThrown){
                    layer.alert(errorThrown);
                },
                complete: function () {
                    layer.closeAll('loading');
                },
                async: true
            });
        // 取消点赞操作
        }else{
            $.ajax({
                type: 'post',
                url: '/web/ranking',
                data: {
                    user_id: $(this).data('uid'),
                    discussion_id: $(this).data('did'),
                },
                dataType: 'json',
                beforeSend: function (xhr) {
                    layer.load(1, {shade: [0.1,'#000']});
                },
                success: function(res, status, xhr){
                    if(status == 'success'){
                        if(res.ServerNo == 'SN000'){
                            layer.alert('取消点赞成功');
                            $(obj).removeClass('fa-heart').addClass('fa-heart-o');
                        }else{
                            layer.alert(res.ResultData);
                        }
                    }
                },
                error: function(xhr, status, errorThrown){
                    layer.alert(errorThrown);
                },
                complete: function () {
                    layer.closeAll('loading');
                },
                async: true
            });
        }
    });
});

