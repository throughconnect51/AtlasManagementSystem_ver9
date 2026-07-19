$(function () {
  // カテゴリ開閉
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });

  // いいね登録
  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  // いいね解除
  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });

  // ----------------- 編集モーダル制御 -----------------
  $('.edit-modal-open').on('click', function () {
    $('.js-modal').fadeIn().css('display', 'flex'); // 表示崩れを防ぐためflexを指定
    var post_title = $(this).attr('post_title');
    var post_body = $(this).attr('post_body');
    var post_id = $(this).attr('post_id');
    
    // モーダル内の入力フォームへ値をセット
    $('.modal-inner-title input').val(post_title);
    $('.modal-inner-body textarea').val(post_body); // text(post_body) から val(post_body) に変更してvalueを確実に書き換えます
    $('.edit-modal-hidden').val(post_id);
    return false;
  });

  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

  // ----------------- 削除モーダル制御 (新規追加) -----------------
  $('.delete-modal-open').on('click', function () {
    $('.js-delete-modal').fadeIn().css('display', 'flex');
    
    var post_id = $(this).attr('post_id');
    
    var deleteUrl = "/bulletin_board/delete/" + post_id;
    $('#deletePostForm').attr('action', deleteUrl);
    
    return false;
  });

  $('.js-delete-modal-close').on('click', function () {
    $('.js-delete-modal').fadeOut();
    return false;
  });

});