<?php


use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
  // creamos unos usuarios
  $users = $this->table('accounts');
  $usersinfo = $this->table('accounts_info');
 
  $data = ['username'    => 'kike@izarmedia.es',
          'hashed' =>  password_hash("kike", PASSWORD_BCRYPT),
          ];
  $users->insert($data)->save();
  $lastID= $this->fetchRow("select LAST_INSERT_ID()")[0];
  $data =[
         'accounts_id' => $lastID,
         'scope' => serialize([
                   'todo' => 5,
                   'categ'=> 5
         ])
  ];
  $usersinfo->insert($data)->save();
 
 
  $data = ['username'    => 'sergio@izarmedia.es',
          'hashed' => password_hash("sergio", PASSWORD_BCRYPT),
          ];
  
  $users->insert($data)->save();
  $lastID= $this->fetchRow("select LAST_INSERT_ID()")[0];
  $data =[
         'accounts_id' => $lastID,
         'scope' => serialize([
                   'todo' => 3,
                   'categ'=> 1
         ])
  ];
  $usersinfo->insert($data)->save();     


    }
}
