<?php


use Phinx\Seed\AbstractSeed;

class Marcas extends AbstractSeed
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
        $data = [

            [
                'marca'    => 'Nestle',
                'producto'    => 'chocolate',
                'alternativa'    => 'valor, suchard'
            ],
            [
                'marca'    => 'Nestle',
                'producto'    => 'chocolate',
                'alternativa'    => 'valor, suchard'
            ],
            [
                'marca'    => 'Nestle',
                'producto'    => 'chocolate',
                'alternativa'    => 'valor, suchard'
               ]
           
         ];
    
        $posts = $this->table('marcas');
        $posts->insert($data)->save();
    }
}
