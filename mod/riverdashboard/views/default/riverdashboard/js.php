<?php
	/**
	 * js for ImprovedRiverdashboard
	 *
	 * @package ImprovedRiverdashboard
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	 global $CONFIG;
?>
<script type="text/javascript">
	$(function($){
		processToggleCommentLink();
		toggleImgSize();
		addComment();
		processShowMoreCommentsLink();
	});

	function processToggleCommentLink(){
		$('.river_item .toggle_comment').click(function(event){
			var item_div = getRiverItemDiv(this);

			$('.item_comments',item_div).toggle();
			$('.item_comment_form',item_div).toggle();
			return false;
		});
	}

	function toggleImgSize(){
		$('.river_object_image_create .goto_full').before('<a href="" class="toggle_size"><?php echo elgg_echo('river:image:toggle_size');?></a> - ');

		$('.river_object_image_create .toggle_size').click(function(){
			var e = this.nextSibling;
			while('IMG' != e.nodeName){
				e = e.nextSibling;
			}
			var size = e.src.substr(e.src.length-5,5);
			var src = e.src.substr(0,e.src.length-5);
			if('small' == size){
				e.src = '../../_graphics/ajax_loader.gif';
				e.src = src+'large';
			}else{
				e.src = '../../_graphics/ajax_loader.gif';
				e.src = src+'small';
			}

			return false;
		});
	}
	/**
	 * load page via ajax when click on comments page link
	 */
	function processShowMoreCommentsLink(){
		$('.river_item .show_more_comments').each(function(i){
			var more_div = getShowMoreDiv(this);
			more_div.attr('id','smdiv'+i);
		});

		$('.river_item .show_more_comments').click(function(eventObject){
			var item_div = getRiverItemDiv(this);
			var guid = parseInt( $('.obj_guid',item_div).text() );

			var more_div = getShowMoreDiv(this);
			var more_div_id = more_div.attr('id');
			var offset = parseInt($('.offset',more_div).text());
			var limit = parseInt($('.limit',more_div).text());
			var left = parseInt($('.left',more_div).text());
			var num_to_get = (limit>left)?left:limit;

			var url = '../riverdashboard/get_comments';

			$.post(url,{'guid':guid,'offset':offset,'limit':num_to_get,'more_div_id':more_div_id},function(response){
				var more_div = $('#'+response.more_div_id);

				more_div.before(response.html);

				if(left <= limit){
					more_div.remove();
				}else{
					$('.offset',more_div).text(offset+num_to_get);

					left = left - limit;
					$('.left',more_div).text(left);

					num_to_get = (limit>left)?left:limit;
					var more_link = $('.show_more_comments',more_div);
					more_link.text( more_link.text().replace(/\d+/,num_to_get) );
				}
			},'json');

			return false;
		});
	}
	/**
	 * post comment via ajax and reload comments
	 */
	function addComment(){
		$('.river_item .item_comments').each(function(i){
			$(this).attr('id','ic'+i);
		});

		$('.river_item .item_comment_form form').submit(function(eventObject){
			$('[name="generic_comment"]',this).attr('disabled','disabled');

			var guid = $('[name="entity_guid"]',this)[0].value;
			var comment_input = $('[name="generic_comment"]',this)[0];
			var comment = comment_input.value;

			if(guid){
				var url = '../riverdashboard/add_comment';

				var item_div = getRiverItemDiv(this);
				var req_id = $('.item_comments',item_div).attr('id');
				$.post(url,
						  {'entity_guid':guid,'generic_comment':comment,'req_id':req_id},
						  function(response){

					$('body').append('<code>'+response.req_id+'</code>');

					$('#page_wrapper').prepend(response.msg);

					var comment_div = $('#'+response.req_id);
					comment_div.append(response.content);

					var item_div = getRiverItemDiv(comment_div);
					var comment_cnt_node = $('.comment_cnt',item_div);

					var comment_cnt = parseInt(comment_cnt_node.text());
					comment_cnt++;

					comment_cnt_node.text(comment_cnt);

					comment_input = $('[name="generic_comment"]',item_div);
					comment_input.val('');
					comment_input.removeAttr('disabled');

				},'json');
			}//if(guid)

			return false;
		});
	}

	/**
	 * return the parent div.river_item of the given node
	 */
	function getRiverItemDiv(node){
		var node = $(node);
		while( !node.hasClass('river_item') ){
			node = node.parent();
			if( node.is('body')){
				return false;
			}
		}
		return node;
	}

	function getShowMoreDiv(node){
		var more_div = $(node);
		while(!more_div.hasClass('generic_comment')){
			more_div = more_div.parent();
			if(more_div.is('body')){
				throw new Exception();
			}
		}
		return more_div;
	}
</script>