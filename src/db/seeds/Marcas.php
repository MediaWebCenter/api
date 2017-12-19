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

        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 1; $i < 100; $i++) {
            $data[] = [
                'idHash'     => md5($i),
                'marca'      => $faker->userName,
                'producto'   => $faker->firstName,
                'alternativa'=> $faker->lastName,
                
            ];
        }

        $this->insert('marcas', $data);
    }
       
    
       
    }

