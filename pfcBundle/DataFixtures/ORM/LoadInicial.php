<?php
namespace Paf\pfcBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
//librerias para codificar:
//use Symfony\Component\Security\Core\SecurityContext;
//use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\Common\Collections\ArrayCollection;
use Paf\pfcBundle\Entity\Producto,
    Paf\pfcBundle\Entity\Libro,
    Paf\pfcBundle\Entity\Serie,
    Paf\pfcBundle\Entity\Pelicula,
    Paf\pfcBundle\Entity\Musica,
    Paf\pfcBundle\Entity\LineaPedido,
    Paf\pfcBundle\Entity\Pedido,
    Paf\pfcBundle\Entity\Cliente;

//implements OrderedFixtureInterface, ContainerAwareInterface
class LoadInicial extends AbstractFixture implements ContainerAwareInterface
{

    protected $manager;
    private   $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load($manager)
    {
        //esta en LoadINICIAL de desymf pero funciona sin declarar...
        //$this->manager = $manager;
        
        for($i = 0; $i < 100; $i++){
            $aux = new Pelicula();
            $aux->setDirector("Director $i");
            $aux->setNombre("NombrePelicula $i"); 
            $aux->setSlug("NombrePelicula$i");
            $aux->setPrecio($i * 0.1);
            $aux->setStock('4');
            if($i<6){
                $aux->setStock('1');
            }
            if($i<8 && $i>=6){
                $aux->setStock('0');
            }            
            $aux->setCreated(new \DateTime("now")); 
            $aux->setDescripcion("Texto de descripcion $i");
            $aux->setDescuento('0.00');
            if($i<20){
                $aux->setDescuento('0.10');
            }
            $aux->setDescatalogado(false);
            if($i<5){
                $aux->setDescatalogado(true);
            }
            $manager->persist($aux);
        }
        $manager->flush();
        
        for($i = 0; $i < 100; $i++){
            $aux = new Musica(); 
            $aux->setAutor("Autor $i"); $aux->setDiscografica("Discografica $i"); 
            $aux->setNombre("NombreDisco $i"); $aux->setSlug("NombreDisco$i");
            $aux->setPrecio($i * 0.1);
            $aux->setStock('4');
            if($i<6){
                $aux->setStock('1');
            }
            if($i<8 && $i>=6){
                $aux->setStock('0');
            }
            $aux->setCreated(new \DateTime("now")); $aux->setDescripcion("Texto de descripcion $i");
            $aux->setDescuento('0.00');
            if($i<20){
                $aux->setDescuento('0.10');
            }
            $aux->setDescatalogado(false);
            if($i<5){
                $aux->setDescatalogado(true);
            }
            $manager->persist($aux);
        }
        $manager->flush();
        
        for($i = 0; $i < 100; $i++){
            $aux = new Serie(); 
            $aux->setDirector("Director $i"); $aux->setTemporada("Temporada $i"); 
            $aux->setNombre("NombreSerie $i"); $aux->setSlug("NombreSerie$i");
            $aux->setPrecio($i * 0.1);
            $aux->setStock('4');
            if($i<6){
                $aux->setStock('1');
            }
            if($i<8 && $i>=6){
                $aux->setStock('0');
            }
            $aux->setCreated(new \DateTime("now")); $aux->setDescripcion("Texto de descripcion $i");
            $aux->setDescuento('0.00');
            if($i<20){
                $aux->setDescuento('0.10');
            }
            $aux->setDescatalogado(false);
            if($i<5){
                $aux->setDescatalogado(true);
            }
            $manager->persist($aux);
        }
        $manager->flush();
        
        for($i = 0; $i < 100; $i++){
            $aux = new Libro(); 
            $aux->setAutor("Autor $i");
            $aux->setNombre("NombreLibro $i"); $aux->setSlug("NombreLibro$i");
            $aux->setPrecio($i * 0.1);
            $aux->setStock('4');
            if($i<6){
                $aux->setStock('1');
            }
            if($i<8 && $i>=6){
                $aux->setStock('0');
            }
            $aux->setCreated(new \DateTime("now")); $aux->setDescripcion("Texto de descripcion $i");
            $aux->setDescuento('0.00');
            if($i<20){
                $aux->setDescuento('0.10');
            }
            $aux->setDescatalogado(false);
            if($i<5){
                $aux->setDescatalogado(true);
            }
            $manager->persist($aux);
        }
        $manager->flush();
        
        //deberia funcionar
        $factory = $this->container->get('security.encoder_factory');
        for($i = 0; $i < 5; $i++){
            $aux = new Cliente(); 
            $aux->setNombre("NombreCliente $i");    $aux->setApellidos("Apellidos $i"); 
            $aux->setAlias("Alias$i");              $aux->setEmail($i.'myemail@hotmail.com');              
            
            //deberia funcionar
            $codificador = $factory->getEncoder($aux);
            $password = $codificador->encodePassword('password', $aux->getSalt());
            $aux->setPassword($password);
            
            //$aux->setPassword("password");
            $manager->persist($aux);
            $this->addReference('cli'.$i, $aux);            
        }
        $manager->flush();
        
            //$aux->setPassword("Password");
            /*// Codificamos el password
            $factory = $this->get('security.encoder_factory');
            $codificador = $factory->getEncoder($usuario);
            $password = $codificador->encodePassword($usuario->getPassword(), $usuario->getSalt());
            $usuario->setPassword($password);*/
            /* //Ni warra de como hacerlo... 
            $factory = $aux->get('security.encoder_factory');
            $encoder = $factory->getEncoder($aux);
            $password = $encoder->encodePassword('password', $aux->getSalt());
            $aux->setPassword($password);*/        
        
        $query = $manager->createQuery('SELECT p FROM PafpfcBundle:Pelicula p WHERE p.precio >= :precio ORDER BY p.precio ASC') 
                ->setParameter('precio', '9.50');
        $productos = $query->getResult();
        for($i = 0; $i < 5; $i++){
            $pedido = new Pedido();
            $pedido->setDireccion('Direccion pedido prueba'.$i);
            $pedido->setCliente($manager->merge($this->getReference('cli'.$i)));
            $manager->persist($pedido);
            $this->addReference('ped'.$i, $pedido);
            $manager->flush();
        }
        $arrCol = new ArrayCollection();
        for($i = 0; $i < 5; $i++){
            foreach($productos as $producto){
                $linea = new LineaPedido($manager->merge($this->getReference('ped'.$i)),$producto, $i+1);
                $manager->persist($linea);
                $manager->flush();
                $arrcol = $linea;
            }
            $pedido->addProductos($arrcol);            
        }
        $manager->flush();      
    }
}
    /*
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load($manager)
    {
        $this->manager = $manager;

        $nombres = array('Adán', 'Adolfo', 'Agustin', 'Albert', 'Alberto', 'Alejandro',
                         'Andrés', 'Antonio', 'Ariel', 'Benjamin', 'Bernardo', 'Carles',
                         'Carlos', 'Cayetano', 'César', 'Cristian', 'Daniel', 'David',
                         'Diego', 'Dimas', 'Eduardo', 'Eneko', 'Esteban', 'Fernando',
                         'Francisco', 'Gonzalo', 'Gregorio', 'Guillermo', 'Haritz', 'Iago',
                         'Ignacio', 'Iker', 'Isaïes', 'Isis', 'Iván', 'Jacob', 'Javier',
                         'Joan', 'Jordi', 'Jorge', 'Jose', 'Juan', 'Kevin', 'Luis', 'Marc',
                         'Marta', 'Miguel', 'Moisés', 'Oriol', 'Oscar', 'Pablo', 'Pedro',
                         'Pere', 'Rafael', 'Raúl', 'Rebeca', 'Rosa', 'Rubén', 'Salvador',
                         'Santiago', 'Sergio', 'Susana', 'Verónica', 'Vicente', 'Víctor',
                         'Victoria', 'Vidal');

        // Los 50 apellidos más comunes en España según el Instituto de Estadística
        $apellidos = array('García', 'Fernández', 'González', 'Rodríguez', 'López', 'Martínez',
                           'Sánchez', 'Pérez', 'Martín', 'Gómez', 'Jiménez', 'Ruiz', 'Hernández',
                           'Díaz', 'Moreno', '�?lvarez', 'Muñoz', 'Romero', 'Alonso', 'Gutiérrez',
                           'Navarro', 'Torres', 'Domínguez', 'Vázquez', 'Gil', 'Ramos', 'Serrano',
                           'Blanco', 'Ramírez', 'Molina', 'Suárez', 'Ortega', 'Delgado', 'Morales',
                           'Castro', 'Rubio', 'Ortíz', 'Marín', 'Sanz', 'Iglesias', 'Núñez',
                           'Garrido', 'Cortés', 'Medina', 'Santos', 'Lozano', 'Cano', 'Castillo',
                           'Gerrero', 'Prieto');

        // -- Cargar datos de PONENTES ----------------------------------------
        $ponentes = array(
            'javierLopez' => array(
                'nombre'    => 'Javier',
                'apellidos' => 'López',
                'biografia' => 'Javier es co-fundador de Flai Webnected, una empresa especializada en el desarrollo de aplicaciones con este framework. Además de programar, también imparte clases de PHP en la Universidad de Córdoba.',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://www.loalf.com/',
                'email'     => 'javier@xxx.xx',
                'linkedin'  => 'http://es.linkedin.com/in/loalf',
                'twitter'   => 'http://www.twitter.com/loalf'
            ),
            'nachoMartin'   => array(
                'nombre'    => 'Ignacio',
                'apellidos' => 'Martín',
                'biografia' => 'Nacho es un programador y emprendedor con una buena lista de proyectos Symfony a sus espaldas. Entusiasta del software libre y de las buenas prácticas, cuando no está frente a una consola con un Vim abierto nota que le falta algo.',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://www.nacho-martin.com',
                'email'     => 'nacho@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/in/ignaciomartinlat',
                'twitter'   => 'http://twitter.com/nacmartin'
            ),
            'marcosLabad'   => array(
                'nombre'    => 'Marcos',
                'apellidos' => 'Labad',
                'biografia' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://www.quevidaesta.com',
                'email'     => 'marcos@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/in/marcoslabad',
                'twitter'   => 'http://twitter.com/esmiz'
            ),
            'albertJessurum' => array(
                'nombre'    => 'Albert',
                'apellidos' => 'Jessurum',
                'biografia' => 'Albert es un desarrollador web, especializado en PHP y apasionado de Symfony. Participa activamente en la comunidad de desarrolladores de Symfony2 con contribuciones al framework, documentación y prestando ayuda en sus listas de correo. Recientemente creo sftuts.com, con la idea de ayudar a nuevos usuarios de Symfony, y en un futuro próximo a su comunidad hispana.',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://sftuts.com',
                'email'     => 'albert@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/in/albertjessurum',
                'twitter'   => 'http://www.twitter.com/ajessu'
            ),
            'pabloDiez' => array(
                'nombre'    => 'Pablo',
                'apellidos' => 'Diez',
                'biografia' => 'Pablo Díez es un desarrollador con alta experiencia en PHP apasionado por Symfony2, MongoDB y el alto rendimiento. Amante del software libre y de las buenas prácticas ha creado varios proyectos como Mandango, Doctrator o Pagerfanta. Le encanta el desarrollo rápido, y para ello ha creado una de las grandes ausencias de Symfony2, un AdminBundle.',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://pablodip.com',
                'email'     => 'pablo@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/pub/pablo-d%C3%ADez/26/163/5b',
                'twitter'   => 'http://twitter.com/pablodip'
            ),
            'pabloGodel' => array(
                'nombre'    => 'Pablo',
                'apellidos' => 'Godel',
                'biografia' => 'Pablo Godel programa con PHP desde muy temprano, cuando descubrió la version PHP3 beta en su Argentina natal. A finales de los 90 se mudó a Estados Unidos donde aún reside actualmente. En 2005 fundó ServerGrove Networks, una empresa de Hosting que se especializa en servicios de hosting de PHP, Symfony, Zend Framework y otras soluciones de código abierto.',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://www.servergrove.com',
                'email'     => 'pablo@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/in/pgodel',
                'twitter'   => 'http://www.twitter.com/pgodel'
            ),
            'alvaroVidela' => array(
                'nombre'    => '�?lvaro',
                'apellidos' => 'Videla',
                'biografia' => '�?lvaro es un programador web con experiencia desarrollando backends para sitios web con alto tráfico. Ha dado charlas sobre diferentes tecnologías en diferentes conferencias en China, Europa y los EEUU. En este momento se encuentra escribiendo el libro "RabbitMQ in Action".',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://videlalvaro.github.com/',
                'email'     => 'alvaro@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/in/alvarovidela',
                'twitter'   => 'http://twitter.com/old_sound'
            ),
            'asierMarques' => array(
                'nombre'    => 'Asier',
                'apellidos' => 'Marqués',
                'biografia' => 'Socio fundador de Blackslot, empresa que ofrece soluciones avanzadas de hosting y desarrollo para internet. Su experiencia profesional, tanto en el campo de desarrollo web como en el de administración de sistemas, le ha permitido desarrollar e investigar tecnologías escalables y de alto rendimiento, temática que le apasiona. También está enganchado al desarrollo de proyectos y negocios en internet.',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://asiermarques.com',
                'email'     => 'asier@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/in/asier',
                'twitter'   => 'http://www.twitter.com/asiermarques'
            ),
            'jordiLlonch' => array(
                'nombre'    => 'Jordi',
                'apellidos' => 'Llonch',
                'biografia' => 'Soy un desarrollador con más de 10 años de experiencia en PHP desde que fundé LAIGU con Joan Valduvieco, mientras estudiaba una ingenieria técnica industrial en electrónica. En 2007 me enamoré de la primera versión de Symfony y basamos todos nuestros desarrollos y filosofia de empresa alrededor de Symfony. Actualmente formo parte del departamento de IT de Ofertix.com dónde soy uno de los responsables de todo el funcionamiento y desarrollo tecnológico de la empresa',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://www.linkedin.com/in/jllonch',
                'email'     => 'jordi@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/in/jllonch',
                'twitter'   => 'http://twitter.com/jordillonch'
            ),
            'joseantonioPio' => array(
                'nombre'    => 'Jose Antonio',
                'apellidos' => 'Pío',
                'biografia' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://www.joseantoniopio.com/',
                'email'     => 'joseantonio@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/pub/jose-antonio-pio-gil/2/791/713',
                'twitter'   => 'http://twitter.com/josetonyp'
            ),
            'javierEguiluz' => array(
                'nombre'    => 'Javier',
                'apellidos' => 'Eguiluz',
                'biografia' => 'Javier es el fundador de symfony.es, el sitio web más influyente de la comunidad hispana de Symfony. Programador apasionado por Symfony desde sus primeras versiones, actualmente se dedica a la formación.',
                'telefono'  => '600XXXXXX',
                'url'       => 'http://javiereguiluz.com',
                'email'     => 'javier@xxx.xx',
                'linkedin'  => 'http://www.linkedin.com/in/javiereguiluz',
                'twitter'   => 'http://www.twitter.com/javiereguiluz'
            )
        );

        foreach ($ponentes as $referencia => $datosPonente) {
            $ponente = new Ponente();

            foreach ($datosPonente as $propiedad => $valor) {
                $ponente->{'set'.ucfirst($propiedad)}($valor);
            }

            $this->addReference($referencia, $ponente);

            $manager->persist($ponente);
        }

        $manager->flush();

        // -- Cargar datos de USUARIOS ----------------------------------------
        $factory = $this->container->get('security.encoder_factory');
        foreach (range(1, 100) as $i) {
            $usuario = new Usuario();

            $usuario->setNombre($nombres[rand(0, count($nombres)-1)]);
            $usuario->setApellidos(
                $apellidos[rand(0, count($apellidos)-1)].
                ' '.
                $apellidos[rand(0, count($apellidos)-1)]
            );

            $dni = substr(rand(), 0, 8);
            $usuario->setDni($dni.substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($dni, "XYZ", "012")%23, 1));

            $usuario->setDireccion('Calle '.$i);
            $usuario->setTelefono('600'.substr(rand(), 0, 6));
            $usuario->setEmail('usuario'.$i.'@desymfony.com');

            $codificador = $factory->getEncoder($usuario);
            $password = $codificador->encodePassword('usuario'.$i, $usuario->getSalt());
            $usuario->setPassword($password);

            $manager->persist($usuario);
        }
        $manager->flush();

        // -- Cargar datos de PONENCIAS ---------------------------------------
        $ponencia = new Ponencia();
        $ponencia->setTitulo('Instalación y puesta a punto');
        $ponencia->setDescripcion('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $ponencia->setFecha(new \DateTime('2011-07-01'));
        $ponencia->setHora(new \DateTime('9:45:00'));
        $ponencia->setDuracion(45);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('javierEguiluz'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('El modelo. Doctrine2');
        $ponencia->setDescripcion('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $ponencia->setFecha(new \DateTime('2011-07-01'));
        $ponencia->setHora(new \DateTime('10:30:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('nachoMartin'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('La vista. Twig');
        $ponencia->setDescripcion('Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
        $ponencia->setFecha(new \DateTime('2011-07-01'));
        $ponencia->setHora(new \DateTime('12:00:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('marcosLabad'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Formularios');
        $ponencia->setDescripcion('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $ponencia->setFecha(new \DateTime('2011-07-01'));
        $ponencia->setHora(new \DateTime('13:00:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('javierLopez'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Backend');
        $ponencia->setDescripcion('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $ponencia->setFecha(new \DateTime('2011-07-01'));
        $ponencia->setHora(new \DateTime('15:30:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('javierEguiluz'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Optimización. Assetic. Pruebas unitarias.');
        $ponencia->setDescripcion('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $ponencia->setFecha(new \DateTime('2011-07-01'));
        $ponencia->setHora(new \DateTime('16:30:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('albertJessurum'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Mandango, un ODM ultrarrápido para PHP, MongoDB ... y Symfony2');
        $ponencia->setDescripcion('Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $ponencia->setFecha(new \DateTime('2011-07-01'));
        $ponencia->setHora(new \DateTime('17:30:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('pabloDiez'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Twig');
        $ponencia->setDescripcion('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $ponencia->setFecha(new \DateTime('2011-07-02'));
        $ponencia->setHora(new \DateTime('09:00:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('javierEguiluz'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Symfony 1, mi viejo amigo');
        $ponencia->setDescripcion('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $ponencia->setFecha(new \DateTime('2011-07-02'));
        $ponencia->setHora(new \DateTime('10:00:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('joseantonioPio'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Microframework Silex');
        $ponencia->setDescripcion('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $ponencia->setFecha(new \DateTime('2011-07-02'));
        $ponencia->setHora(new \DateTime('11:30:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('nachoMartin'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Rendimiento en aplicaciones web con Symfony2');
        $ponencia->setDescripcion('Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $ponencia->setFecha(new \DateTime('2011-07-02'));
        $ponencia->setHora(new \DateTime('12:30:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('asierMarques'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Creación de aplicaciones móviles con Symfony2');
        $ponencia->setDescripcion('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $ponencia->setFecha(new \DateTime('2011-07-02'));
        $ponencia->setHora(new \DateTime('15:00:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('pabloGodel'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Reduciendo el acoplamiento entre aplicaciones con RabbitMQ');
        $ponencia->setDescripcion('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $ponencia->setFecha(new \DateTime('2011-07-02'));
        $ponencia->setHora(new \DateTime('16:00:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('alvaroVidela'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Symfony y 3 millones de usuarios, nuestro día a día');
        $ponencia->setDescripcion('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $ponencia->setFecha(new \DateTime('2011-07-02'));
        $ponencia->setHora(new \DateTime('17:00:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('jordiLlonch'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $ponencia = new Ponencia();
        $ponencia->setTitulo('Deja los plugins en casa, Habemus Bundles!');
        $ponencia->setDescripcion('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $ponencia->setFecha(new \DateTime('2011-07-02'));
        $ponencia->setHora(new \DateTime('18:00:00'));
        $ponencia->setDuracion(60);
        $ponencia->setIdioma('es');
        $ponencia->setPonente(
            $manager->merge($this->getReference('albertJessurum'))
        );
        $ponencia = $this->addUsuarios($ponencia);

        $manager->persist($ponencia);

        $manager->flush();

    }

     //* Añade usuarios aleatoriamente a una ponencia asegurándose de que no se repita un mismo usuario
     //*
     //* @param $entidad Entidad a la que se añaden los usuarios
     //* @param string $num Número de usuarios que se añade en cada ponencia
     //* @return La misma entidad pero con los usuarios añadidos
     
    private function addUsuarios($entidad, $num = null)
    {
        $usuarios = $this->manager->getRepository('DesymfonyBundle:Usuario')->findAll();
        $total = isset($num) ?: rand(20, 50);

        $asistentes = array();

        for ($i=0; $i<$total; $i++) {
            $asistente = $usuarios[rand(0, count($usuarios)-1)];

            while (in_array($asistente->getId(), $asistentes)) {
                $asistente = $usuarios[rand(0, count($usuarios)-1)];
            }
            $asistentes[] = $asistente->getId();

            $entidad->addUsuarios($asistente);
        }

        return $entidad;
    }



    public function getOrder()
    {
        return 1;
    }
}*/
