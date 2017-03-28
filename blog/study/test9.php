<?php 

/*
	session的使用
	通过为每个独立用户分配唯一的会话 ID，可以实现针对不同用户分别存储数据的功能。 会话通常被用来在多个页面请求之间保存及共享信息。 一般来说，会话 ID 通过 cookie 的方式发送到浏览器，并且在服务器端也是通过会话 ID 来取回会话中的数据。 如果请求中不包含会话 ID 信息，那么 PHP 就会创建一个新的会话，并为新创建的会话分配新的 ID。

	会话的工作流程很简单。当开始一个会话时，PHP 会尝试从请求中查找会话 ID （通常通过会话 cookie）， 如果请求中不包含会话 ID 信息，PHP 就会创建一个新的会话。 会话开始之后，PHP 就会将会话中的数据设置到 $_SESSION 变量中。 当 PHP 停止的时候，它会自动读取 $_SESSION 中的内容，并将其进行序列化， 然后发送给会话保存管理器器来进行保存。

	默认情况下，PHP 使用内置的文件会话保存管理器（files）来完成会话的保存。 也可以通过配置项 session.save_handler 来修改所要采用的会话保存管理器。 对于文件会话保存管理器，会将会话数据保存到配置项 session.save_path 所指定的位置。

	可以通过调用函数 session_start() 来手动开始一个会话。 如果配置项 session.auto_start 设置为1， 那么请求开始的时候，会话会自动开始。

	PHP 脚本执行完毕之后，会话会自动关闭。 同时，也可以通过调用函数 session_write_close() 来手动关闭会话。
 */


// 无论是设置,读取,销毁session,都需要先开启session
session_start();

// 开启session之后,可以直接写session变量
$_SESSION['area'] = 'testSession';

// session是存储在服务器的，然后生成一个sessionID
// sessionID=>QUIDUHQIWD---即一个随机数
// 给浏览器cookie--然后cookie把这个字符串发送给
// 服务器，然后服务器从文件中寻找里面的内容
// 所以session相对于cookie是更加安全的，因为
// 是存在服务器的，但是存在一个问题，那就是
// 一旦用户很多，那么服务器的session太多，
// 那么会影响服务器的响应速度


// session的销毁
$_SESSION = array(); 
//这个只是删除sessionid的值,但不会删除服务器中的存储这个session的内容的文件

session_destroy();
// 这个删掉了值，而且文件也删除掉了

 ?>