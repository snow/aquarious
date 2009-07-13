<?php

	/**
	 * Elgg riverdashboard CSS
	 *
	 * @package riverdashboard
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */

?>
/* START SnowMod */
.river_item .item_body p {
	line-height: 18px;
}
.river_item .blog_post {
	margin-top:5px;
	padding:5px;
}
.river_item .blog_post h2 {
	border-bottom:0.5px dotted #AAAAAA;
	padding-bottom:5px;
	margin-bottom:5px;
}
.post_to_wire {
	background: white;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	margin:0 10px 10px 10px;
	padding:10px;
}
.post_to_wire input[type="submit"] {
	margin:0;
}
/* reply form */
#river_post-textarea {
	width: 664px;
	height: 40px;
	padding: 6px;
	font-family: Arial, 'Trebuchet MS','Lucida Grande', sans-serif;
	font-size: 100%;
	color:#666666;
}
/* IE 6 fix */
* html #river_post-textarea {
	width: 642px;
}

input.thewire_characters_remaining_field {
	color:#333333;
	border:none;
	font-size: 100%;
	font-weight: bold;
	padding:0 2px 0 0;
	margin:0;
	text-align: right;
	background: white;
}
input.thewire_characters_remaining_field:focus {
	border:none;
	background:white;
}
.thewire_characters_remaining {
	text-align: right;
}


.sidebarBox .membersWrapper {
	background: white;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	padding:6px;
}
.item_body img{
	max-width:98%;
	height:auto;
	padding:2px;
	border-top:1px #AAA solid;
	border-right:2px #333 solid;
	border-bottom:2px #333 solid;
	border-left:1px #AAA solid;
}
/* IE6
.item_body img{
	*width:expression(this.clientWidth > 601?"600px":"auto");
}
.collapsable_box .item_body img{
	*width:expression(this.clientWidth > 201?"200px":"auto");
}*/
.river_item .usericon {
	position:absolute;
	*margin-left:-50px;
}
.river_item .generic_comment div.usericon{
	margin: 0;
}
.river_item .item_body{
	margin-left:48px;
	padding:3px;
}
.item_body .search_listing {
	margin:0;
	padding:0;
}
.item_body .search_listing .search_listing_info {
	margin:0;
	padding:0;
}
.river_item .item_body p {
	padding:0;
}
.river_item .item_comments,
.river_item .item_comment_form{
	margin:10px 10px 0 45px;
	display: none;
}
.river_item .item_comments p{
	padding:0;
}
.river_item .item_comments .generic_comment_details {
	margin-left:50px;
}
.river_item .generic_comment_details p {
	margin: 0;
}
.river_item .generic_comment {
	background: #DEDEDE;
	-moz-border-radius: 4px;
    -webkit-border-radius: 4px;
	margin:1px 0 0 0;
	*margin: 1px 0 0 3px !important;
	padding: 5px;
}
.river_item .generic_comment_owner {
	padding-top:5px !important;
}
.river_item .item_info{
	margin-left:50px;
	border-top:1px solid #AAA;
}
.hide_basic_river_item_view_time {
	display:none;
}
.basic_river_item_view {
	padding:0 0 0 21px;
}
/* END SnowMod */
.sidebarBox #thewire_sidebarInputBox {
	width:178px;
}
.sidebarBox .last_wirepost {
	margin:20px 0 20px 0;
}
.sidebarBox .last_wirepost .thewire-singlepage {
	margin:0;
}
.sidebarBox .last_wirepost .thewire-singlepage .thewire_options {
	display:none;
}
.sidebarBox .last_wirepost .thewire-singlepage .note_date {
	line-height: 1em;
	padding:3px 0 0 0;
	width:142px;
}
.sidebarBox .last_wirepost .thewire-singlepage .note_body {
	color:#666666;
	line-height: 1.2em;
}
.sidebarBox .last_wirepost .thewire-singlepage .thewire-post {
	background-position: 130px bottom;
}
.sidebarBox .thewire_characters_remaining {
	float:right;
}
.sidebarBox input.thewire_characters_remaining_field {
	background: #dedede;
}
.sidebarBox input.thewire_characters_remaining_field:focus {
	background: #dedede;
	border:none;
}
.sidebarBox input#thewire_submit_button {
	margin:2px 0 0 0;
	padding:2px 2px 1px 2px;
	height:auto;
}
.sidebarBox .membersWrapper .recentMember {
	margin:2px;
	float:left;
}
/* br necessary for ie6 & 7 */
.sidebarBox .membersWrapper br {
	height:0;
	line-height:0;
}
.welcomemessage {
	background:white;
}
.riverdashboard_filtermenu {
	margin:10px 0 10px 0;
}
.river_pagination{
	text-align:center;
	margin-top:10px;
}
.river_pagination .forward,
.river_pagination .back {
	border:1px solid #cccccc;
	color:#4690d6;
	text-align: center;
	font-size: 12px;
	font-weight: normal;
	margin:0 6px 0 0;
	padding:0 4px 1px 4px;
	cursor: pointer;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
}
.river_pagination .forward:hover,
.river_pagination .back:hover {
	background:#4690d6;
	color:white;
	text-decoration: none;
	border:1px solid #4690d6;
}
.river_pagination .back {
	margin:0 20px 0 0;
}
/* IE6 */
* html .river_pagination { margin-top:17px; }
/* IE7 */
*:first-child+html .river_pagination { margin-top:17px; }

/* activity widget */
.collapsable_box_content .river_item p {
	color:#333333;
}

.collapsable_box_content .content_area_user_title h2 {
	font-size:1.25em;
	line-height:1.2em;
	margin:0;
	padding:0 0 2px 0;
	color:#4690d6;
}
.river_content img {
	margin:2px 0 2px 20px;
}




