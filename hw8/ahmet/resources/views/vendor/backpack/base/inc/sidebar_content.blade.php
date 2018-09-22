<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<li><a href='{{ backpack_url('user') }}'><i class='fa fa-user'></i> <span>Users</span></a></li>
<li><a href='{{ backpack_url('article') }}'><i class='fa fa-newspaper-o'></i> <span>Articles</span></a></li>
<li><a href='{{ backpack_url('comment') }}'><i class='fa fa-comments'></i> <span>Comments</span></a></li>
<li><a href='{{ backpack_url('category') }}'><i class='fa fa-list-alt'></i> <span>Categories</span></a></li>