(function($) {
  $(document).ready(function() {
    $('.icon_search').click(function() {
      //$('.input_search').fadeToggle()
      $('.input_search').animate({
        width: 'toggle'
      }, 500);
    });

    //hover特效
    function menu_item_hover($parent_item, $child_item, $acive_class) {
      $($parent_item).after('<div class ="active_bar"></div>');
      //配合jquery position對 parent 元素下相對位置
      $($parent_item).parent().css({
        'position': 'relative',
      })
      //初始位置
      $($parent_item).children($child_item + $acive_class).each(function() {
        $('.active_bar').css({
          'left': $(this).position().left,
          'width': $(this).width(),
          'opacity': '100',
        })
      })
      //hover後位置
      $($parent_item).children($child_item).each(function() {
        //console.log($(this).position().left);
        $(this).hover(function() {
          $('.active_bar').css({
            'left': $(this).position().left,
            'width': $(this).width(),
          })
        })
      })
    }

    setTimeout(()=> {
      menu_item_hover('#menu > ul', 'li', '.current-menu-item');
    },500);
  })
})(jQuery)
