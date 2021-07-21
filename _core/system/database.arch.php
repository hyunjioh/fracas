<?
function dbTable($case){
  switch($case):
    /*
    // 테이블 구조 `G_Member`
    */
    case "Member":
      $Table[] = "
      CREATE TABLE IF NOT EXISTS `G_Member` (
        `m_idx` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '회원 일련번호',
        `m_num` int(10) unsigned NOT NULL COMMENT '회원번호 : 1 + 랜덤(9자리) ※ 중복 체크',

        `m_id` varchar(20) NOT NULL COMMENT '회원 ID',
        `m_recomID` varchar(20) NOT NULL COMMENT '추천인 ID',
        `m_linkCode` varchar(50) NOT NULL COMMENT '외부링크용 ID',
        `m_passwd` varchar(50) NOT NULL COMMENT '회원 password',
        `m_pwdQuestion` varchar(100) DEFAULT NULL COMMENT '비밀번호찾기 질문',
        `m_pwdAnswer` varchar(255) DEFAULT NULL COMMENT '비밀번호찾기 답',

        `m_confirm` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT '회원승인 상태',
        `m_status` enum('normal','secede') NOT NULL DEFAULT 'normal' COMMENT '회원상태 : 정상/탈퇴',
        `m_level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '회원등급',
        `m_group` varchar(20) DEFAULT NULL COMMENT '회원그룹',

        `m_foreign` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '내/외국인',
        `m_country` varchar(3) DEFAULT NULL COMMENT '국가',

        `m_name` varchar(30) NOT NULL COMMENT '이름',
        `m_prefix` varchar(10) DEFAULT NULL COMMENT '접두어',
        `m_fName` varchar(50) NOT NULL COMMENT 'first name',
        `m_lName` varchar(50) NOT NULL COMMENT 'last name',
        `m_mMame` varchar(50) NOT NULL COMMENT 'middle name',

        `m_nick` varchar(30) DEFAULT NULL COMMENT '별명',
        `m_authroot` char(1) DEFAULT NULL COMMENT '본인인증구분',
        `m_hash` varchar(32) DEFAULT NULL COMMENT '본인인증리턴값',
        `m_jumin1` varchar(32) DEFAULT NULL COMMENT '주민번호 1',
        `m_jumin2` varchar(32) DEFAULT NULL COMMENT '주민번호 2',
        `m_bizNum` varchar(32) DEFAULT NULL COMMENT '사업자등록번호',
        `m_sex` enum('M','F') NOT NULL DEFAULT 'M' COMMENT '성별',
        `m_birthday` varchar(12) DEFAULT NULL COMMENT '생년월일',

        `m_major` varchar(100) DEFAULT NULL COMMENT '전공',
        `m_job1` varchar(50) DEFAULT NULL COMMENT '직종 1',
        `m_job2` varchar(50) DEFAULT NULL COMMENT '직종 2',
        `m_company` varchar(50) DEFAULT NULL COMMENT '회사',
        `m_position` varchar(100) DEFAULT NULL COMMENT '직위',
        `m_department` varchar(100) DEFAULT NULL COMMENT '부서',

        `m_email` varchar(128) DEFAULT NULL COMMENT 'E-mail',
        `m_homepage` varchar(128) DEFAULT NULL COMMENT '홈페이지',
        `m_tel` varchar(20) DEFAULT NULL COMMENT '일반전화',
        `m_hp` varchar(20) DEFAULT NULL COMMENT '무선전화',
        `m_fax` varchar(20) DEFAULT NULL COMMENT 'FAX',
        `m_zip` varchar(7) DEFAULT NULL COMMENT '우편번호',
        `m_addr1` varchar(128) DEFAULT NULL COMMENT '주소 1',
        `m_addr2` varchar(128) DEFAULT NULL COMMENT '주소 2',

        `m_file` varchar(50) DEFAULT NULL COMMENT '파일 (프로필사진 등)',

        `m_smsYN` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'SMS Y/N',
        `m_smsDate` datetime DEFAULT NULL COMMENT 'SMS 수정일',
        `m_smsIP` varchar(15) NOT NULL DEFAULT '' COMMENT 'SMS 수정 IP',

        `m_emailYN` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'E-mail Y/N',
        `m_emailDate` datetime DEFAULT NULL COMMENT 'E-mail 수정일',
        `m_emailIP` varchar(15) DEFAULT NULL COMMENT 'E-mail 수정 IP',

        `m_wDate` datetime DEFAULT NULL COMMENT '가입일',
        `m_mDate` datetime DEFAULT NULL COMMENT '회원정보 수정일',
        `m_wIP` varchar(15) DEFAULT NULL COMMENT '가입 IP',
        `m_mIP` varchar(15) DEFAULT NULL COMMENT '회원정보 수정 IP',

        `m_visit` int(9) unsigned NOT NULL DEFAULT '0' COMMENT '방문 횟수',
        `m_visitIP` varchar(15) DEFAULT NULL COMMENT '최근 접속 IP',
        `m_lastVisit` datetime DEFAULT NULL COMMENT '최근 접속일시',
        `m_point` int(11)  NOT NULL DEFAULT '0' COMMENT '회원 포인트',
        `m_comment1` text DEFAULT NULL COMMENT '자기소개',
        `m_comment2` text DEFAULT NULL COMMENT '비고',

        PRIMARY KEY (`m_idx`),
        KEY `m_num` (`m_num`),
        KEY `m_id` (`m_id`),
        KEY `m_wDate` (`m_wdate`)
      )
      ";
    break;
  endswitch;
  return $Table;
}
?>