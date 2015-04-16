<?php

namespace Diego\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Diego\StoreBundle\Entity\Product;
use Diego\StoreBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Email;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DiegoStoreBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function createAction()
    {
        $product = new Product();
        $product->setName('Nombre1');
        $product->setPrice('3.91');
        $product->setDescription('aaa');
        $product->setGender('sd');
        
        $validator = $this->get('validator');
        $errors = $validator->validate($product, array('registration'));
 
    if (count($errors) > 0) {
        /*
         * Utiliza el método __toString de la variable $errors, que
         * es un objeto de tipo ConstraintViolationList. Así se obtiene
         * una cadena de texto lista para poder depurar los errores.
         */
        return $this->render('DiegoStoreBundle:Default:index.html.twig', array(
        'errors' => $errors,
        ));
    }

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response('Created product id '.$product->getId());
    }
    
    

    public function updateAction($id, $name)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('DiegoStoreBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName($name);
        $em->flush();

        return new Response('Nuevo nombre del producto: '.$product->getName());
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('DiegoStoreBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        
        $em->remove($product);
        $em->flush();


        return new Response('Producto eliminado: '.$product->getName());
    }
    

    public function showAction($name,$description)
        {
            /*$product = $this->getDoctrine()
                ->getRepository('DiegoStoreBundle:Product')
                ->find($id);*/
            
            

            $repository = $this->getDoctrine()
                ->getRepository('DiegoStoreBundle:Product');


            $product = $repository->findOneBy(
                array('name'  => $name,'description' => $description)
            );
            

            if (!$product) {
                throw $this->createNotFoundException(
                    'Producto no encontrado'
                );
            }

           return new Response('Nombre del producto '.$product->getName());
        }


        public function retrieveAction()
        {
            
            $em = $this->getDoctrine()->getManager();
            $products = $em->getRepository('DiegoStoreBundle:Product')
               ->findAllOrderedByName();

            return $this->render('DiegoStoreBundle:Store:list.html.twig', array('products' => $products));
        }
        
        public function createProductAction()
    {
        $category = new Category();
        $category->setName('Main Products');
 
        $product = new Product();
        $product->setName('Foo');
        $product->setDescription('Foo_desc');
        $product->setPrice(19.99);
        // relaciona este producto con una categoría
        $product->setCategory($category);
 
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($product);
        $em->flush();
 
        return new Response(
            'Created product id: '.$product->getId()
            .' and category id: '.$category->getId()
        );
    }
    
    public function addEmailAction($email)
    {
        $emailConstraint = new Email();
        // puedes establecer todas las opciones de restricción
        // de esta manera
        $emailConstraint->message = 'Invalid email address';

        // usa el servicio validator para validar el valor
        $errorList = $this->get('validator')->validateValue(
            $email,
            $emailConstraint
        );

        if (count($errorList) == 0) {
            // esta es una dirección de correo válida
        } else {
            // esta NO es una dirección de correo electrónico válida
            $errorMessage = $errorList[0]->getMessage();

            return new Response($errorMessage);
        }

        return new Response('Joya');
    }
}
