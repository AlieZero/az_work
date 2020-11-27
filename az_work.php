<?php
/*
Plugin Name: 最后测试题
Plugin URI: http://www.aliezero.com
Description: 可以显示一个表单，两个字段，一个名字，一个单位，用户提交后, 存到数据库里，并把数据库的所有存的记录显示出来
Version: 1.0
Author: aliezero
Author URI: http://www.aliezero.com
*/
date_default_timezone_set('Asia/Shanghai');

class az_work{
	function az_work(){		
		register_activation_hook(__FILE__,array($this,'az_work_install'));
		add_action('admin_menu',array($this,'az_menu_fun'));
	}
	
	function az_work_install(){
		global $wpdb;
		$table_name=$wpdb->prefix . "azWork";
			
		if($wpdb->get_var("show tables like $table_name") != "$table_name"){
			$sql="CREATE TABLE ". $table_name ."( 
				`id` INT(11) NOT NULL AUTO_INCREMENT , 
				`name` VARCHAR(10) NOT NULL , 
				`compony` VARCHAR(20) NOT NULL , 
				PRIMARY KEY (`id`));";
				
			require_once(ABSPATH . "wp-admin/includes/upgrade.php");
			
			dbDelta($sql);
		}
	}
	
	function az_menu_fun(){
		add_menu_page(
			'我的插件首页',  //页面的title，和显示在<title>标签里一样
			'我的插件',  //在控制面板中显示的名称
			'manage_options',  //要浏览菜单所要的最低权限
			'az_menu',   //要引用该菜单别名，必须是唯一的
			array($this,'az_menu_page'),   //要显示菜单对应的页面内容所调用的函数
			plugin_dir_url(__FILE__) . 'aaa.png',   //菜单的icon图片的url
			99
		);
	}
	
	function az_menu_page(){
		global $wpdb;
		$table_name=$wpdb->prefix . "azwork";
		
		if(!empty($_POST)){
			$wpdb->update("$table_name",array(
				'name'=>$_POST['name'],
				'compony'=>$_POST['compony']
			),array('id'=>1));
			?>
			<div id="message" class="updated"><p><strong>保存成功</strong></p></div>
			<?php
		}
		
		$sql = "SELECT * FROM `$table_name`";
		$row = $wpdb->get_row($sql,ARRAY_A);
		
		$name = $row['name'];
		$compony = $row['compony'];
		
		?>
		<div class="wrap">
			<h2>_(:3J∠)_</h2>
			<form action="" method="post">
				<table>
					<tr>
						<th>名字</th>
						<td><input type="text" name="name" value="<?php echo $name; ?>"></td>
					</tr>
					<tr>
						<th>单位</th>
						<td><input type="text" name="compony" value="<?php echo $compony; ?>"></td>
					</tr>
				</table>
				<input type="submit" name="submint" value="保存设置">
			</form>
		</div>
		<?php
	}
}

new az_work();
