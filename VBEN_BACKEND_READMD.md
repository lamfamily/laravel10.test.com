## table design
### users table
- id
- username
- real_name
- avatar
- email
- password
- phone
- status
- last_login_time
- last_login_ip
- remark
- rememberToken()
- timestamps()
- softDeletes()

### roles table
- id
- name
- status
- remark
- timestamps()

### menus table
- id
- pid
- name
- status
- type 菜单类型：1-目录，2-菜单，3-按钮，4-内嵌，5-外链
- icon
- path
- component
- timestamps()
