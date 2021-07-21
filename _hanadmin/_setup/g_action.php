<?
	if(!defined("_g_board_include_")) exit; // Inclde Check
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');

	$req['board_id']         = Input('board_id');
	$req['board_name']       = Input('board_name');
	$req['table_board']      = Input('table_board');
	$req['table_attach']     = Input('table_attach');
	$req['table_comment']    = Input('table_comment');
	$req['page_limit']       = Input('page_limit');
	$req['page_limit']       = SetValue($req['page_limit'],'digit', 10);
	$req['page_block']       = Input('page_block');
	$req['page_block']       = SetValue($req['page_block'],'digit', 10);
	$req['use_file']         = Input('use_file');
	$req['use_file']         = SetValue($req['use_file'],'digit', 0);
	$req['use_reply']        = Input('use_reply');
	$req['use_reply']        = SetValue($req['use_reply'],'alpha', 'N');
	$req['use_comment']      = Input('use_comment');
	$req['use_comment']      = SetValue($req['use_comment'],'alpha', 'N');
	$req['use_category']     = Input('use_category');
	$req['use_category']     = SetValue($req['use_category'],'alpha', 'N');

	$req['subject_length_main']  = Input('subject_length_main');
	$req['subject_length_main']  = SetValue($req['subject_length_main'],'digit', 30);
	$req['subject_length_board'] = Input('subject_length_board');
	$req['subject_length_board'] = SetValue($req['subject_length_board'],'digit', 60);
	$req['content_length']       = Input('content_length');
	$req['content_length']       = SetValue($req['content_length'],'digit', 200);
	$req['thumb_s_size']         = Input('thumb_s_size');
	$req['thumb_s_size']         = SetValue($req['thumb_s_size'],'digit', 120);
	$req['thumb_m_size']         = Input('thumb_m_size');
	$req['thumb_m_size']         = SetValue($req['thumb_m_size'],'digit', 200);
	$req['thumb_b_size']         = Input('thumb_b_size');
	$req['thumb_b_size']         = SetValue($req['thumb_b_size'],'digit', 200);
	$req['file_max_size']        = Input('file_max_size');
	$req['file_check_type']      = Input('file_check_type');
	$req['file_check_ext']       = Input('file_check_ext');
	$req['level_list']           = Input('level_list');
	$req['level_list']           = SetValue($req['level_list'],'digit', 0);
	$req['level_view']           = Input('level_view');
	$req['level_view']           = SetValue($req['level_view'],'digit', 0);
	$req['level_write']          = Input('level_write');
	$req['level_write']          = SetValue($req['level_write'],'digit', 1);
	$req['level_modify']         = Input('level_modify');
	$req['level_modify']         = SetValue($req['level_modify'],'digit', 1);
	$req['level_reply']          = Input('level_reply');
	$req['level_reply']          = SetValue($req['level_reply'],'digit', 1);
	$req['level_download']       = Input('level_download');
	$req['level_download']       = SetValue($req['level_download'],'digit', 1);
	$req['level_delete']         = Input('level_delete');
	$req['level_delete']         = SetValue($req['level_delete'],'digit', 1);
	$req['level_comment']        = Input('level_comment');
	$req['level_comment']        = SetValue($req['level_comment'],'digit', 1);


	if($req['mode']){
			switch($req['mode']):










				case "newData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					$Field = array(
						"board_id"     => $req['board_id'],
						"board_name"   => $req['board_name'],
						"table_board"  => $req['table_board'],
						"table_attach" => $req['table_attach'],
						"table_comment" => $req['table_comment'],
						"page_limit"    => $req['page_limit'],
						"page_block"    => $req['page_block'],
						"use_file"      => $req['use_file'],
						"use_reply"     => $req['use_reply'],
						"use_comment"   => $req['use_comment'],
						"use_category"  => $req['use_category'],
						"subject_length_main"  => $req['subject_length_main'],
						"subject_length_board" => $req['subject_length_board'],
						"content_length"      => $req['content_length'],
						"thumb_s_size"        => $req['thumb_s_size'],
						"thumb_m_size"        => $req['thumb_m_size'],
						"thumb_b_size"        => $req['thumb_b_size'],
						"file_max_size"       => $req['file_max_size'],
						"file_check_type"     => $req['file_check_type'],
						"file_check_ext"      => $req['file_check_ext'],
						"level_list"          => $req['level_list'],
						"level_view"          => $req['level_view'],
						"level_write"         => $req['level_write'],
						"level_modify"        => $req['level_modify'],
						"level_reply"         => $req['level_reply'],
						"level_download"      => $req['level_download'],
						"level_delete"       => $req['level_delete'],
						"level_comment"      => $req['level_comment'],
					);

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT = mysql_query($Query);
					if($RESULT > 0){
						$Pidx = LAST_INSERT_ID();
						$subDir = date("Y/m/d");
						AttachProcess($Pidx, $subDir);
						locationReplace($href,$msg['data_registered']);
					}else{
						locationReplace($req['_referer_'],$msg['data_error']);				
					}
					break;










				case "updateData":
					if(new_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					$Field = array(
						"board_id"     => $req['board_id'],
						"board_name"   => $req['board_name'],
						"table_board"  => $req['table_board'],
						"table_attach" => $req['table_attach'],
						"table_comment" => $req['table_comment'],
						"page_limit"    => $req['page_limit'],
						"page_block"    => $req['page_block'],
						"use_file"      => $req['use_file'],
						"use_reply"     => $req['use_reply'],
						"use_comment"   => $req['use_comment'],
						"use_category"  => $req['use_category'],
						"subject_length_main"  => $req['subject_length_main'],
						"subject_length_board" => $req['subject_length_board'],
						"content_length"      => $req['content_length'],
						"thumb_s_size"        => $req['thumb_s_size'],
						"thumb_m_size"        => $req['thumb_m_size'],
						"thumb_b_size"        => $req['thumb_b_size'],
						"file_max_size"       => $req['file_max_size'],
						"file_check_type"     => $req['file_check_type'],
						"file_check_ext"      => $req['file_check_ext'],
						"level_list"          => $req['level_list'],
						"level_view"          => $req['level_view'],
						"level_write"         => $req['level_write'],
						"level_modify"        => $req['level_modify'],
						"level_reply"         => $req['level_reply'],
						"level_download"      => $req['level_download'],
						"level_delete"       => $req['level_delete'],
						"level_comment"      => $req['level_comment'],
					);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}
					$RESULT = mysql_query("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE  idx = '".$req['idx']."'");
					if($RESULT > 0){
						$Pidx = $req['idx'];
						$subDir = date("Y/m/d");
						AttachSelectDel($Pidx, $_POST['files_del']);
						AttachProcess($Pidx, $subDir);
						locationReplace($href."&at=view&idx=$req[idx]",$msg['data_modified']);
					}else{
						locationReplace($req['_referer_'],$msg['data_error']);				
					}
					break;






				case "deleteData":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where  idx = '".$req['idx']."'");

					if($CHECK){
							$RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE idx = '".$req['idx']."'");
							if($RESULT >= 0){
								locationReplace($href,$msg['data_deleted']);
							}else{
								locationReplace($req['_referer_'],$msg['data_error']);				
							}
					}else{
							locationReplace($Board['Link']);						
					}
					break;









			endswitch;
	}
?>