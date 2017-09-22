API 文档

接口地址: 10.21.62.14

1.登录     ： /login/login
  传递方式 ： post
  参数     ： string username, string password
  返回     ： 成功       ：{200, '登录成功', data['user_id', 'username']}
	      失败       ：{200, '登录失败'}
	      用户名为空 ：{200, '用户名为空'}
	      密码为空   ：{200, '密码为空'}

2.用户名校验 ： /login/check
  传递方式   ： post
  参数       ： string username
  返回       ： 成功  ： {200, '该用户名可用'} 
		失败  ： {200, '该用户名已被注册'}
3.注册	   ： /login/register
  传递方式 ： post
  参数     ： string username, string password
  返回	   ： 成功      ：{200, '注册成功', data['user_id']}
	      失败      ：{500, '注册失败'}
 		 	  {200, '用户名已存在'} 
	      密码为空  ：{200, '用户名为空'}
	      用户名为空：{200, '密码为空'}

4.保存文章 : /admin/save 
  传递方式 ：post
  参数     ： string username, string type, string content, int status[1,2,3], string collection, string title
  返回	   ： 成功       : {200, '保存成功', data['articleId' => ]}
	      失败       ：{200, '保存失败'}
	      信息不完整 : {200, '信息不完整'}
	      文件不可写 : {200, '保存到文件中失败'}
 
5.获取文章 : /index/getArticle
  传递方式 : get 
  参数     ：int articleId, string username
  返回     ：成功   	 ： {200, '获取内容成功', $data['content', 'username', 'type', 'pv', encourage, admiration, date, status, title]}
	     失败 	 ： {200, '获取内容失败'}
  	     信息不完整  ： {200， '信息不完整'}

6.获取文章分页信息 ： /index/getPageBean
  传递方式         ： get
  参数 		   ： 

