<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

// Se importa la clase Vehicle
use App\Entity\Vehicle;

// Se define un controlador para Vehicle
#[Route('/api', name: 'api_')]
class VehicleController extends AbstractController
{
    // Funcion que lista todos los vehiculos que no se hayan vendido (METODO GET)
    #[Route('/vehicles', name: 'vehicles_list', methods:['get'] )]
    public function vehicles_lists(ManagerRegistry $doctrine): JsonResponse
    {
        // Obtenemos todos los vehiculos de la base de datos que no se hayan vendido
        $vehicles = $doctrine
            ->getRepository(Vehicle::class)
            ->findBy(
                ['sold' => false]
            );
   
        $data = [];
   
        // Obtenemos todos los valores para cada vehiculo de los obtenidos anteriormente
        foreach ($vehicles as $vehicle) {
           $data[] = [
               'id' => $vehicle->getId(),
               'plate' => $vehicle->getPlate(),
               'model' => $vehicle->getModel(),
               'brand' => $vehicle->getBrand(),
               'color' => $vehicle->getColor(),
               'image_path' => $vehicle->getImagePath(),
               'price' => $vehicle->getPrice(),
               'sold' => $vehicle->isSold()
           ];
        }

        // Enviamos los datos en un JSON al cliente
        return $this->json($data);
    }

    #[Route('/vehicles/{id}', name: 'vehicle_detail', methods:['get'] )]
    public function vehicle_detail(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        // Buscamos el vehiculo por el ID proporcionado en la base de datos
        $vehicle = $doctrine->getRepository(Vehicle::class)->find($id);
   
        // Si no encontramos dicho vehiculo, devolvemos un mensaje de error en JSON con codigo de error 404
        if (!$vehicle) {
            return $this->json('No se ha encontrado ningún vehículo con id ' . $id, 404);
        }
   
        // Obtenemos todos los valores del vehiculo
        $data = [
            'id' => $vehicle->getId(),
            'plate' => $vehicle->getPlate(),
            'model' => $vehicle->getModel(),
            'brand' => $vehicle->getBrand(),
            'color' => $vehicle->getColor(),
            'image_path' => $vehicle->getImagePath(),
            'price' => $vehicle->getPrice(),
            'sold' => $vehicle->isSold()
        ];

        // Enviamos los datos en un JSON al cliente
        return $this->json($data);
    }

    // Funcion que inserta un nuevo vehiculo (METODO POST)
    #[Route('/vehicles', name: 'vehicles_create', methods:['post'] )]
    public function vehicles_create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
   
        // Creamos un nuevo Vehiculo y lo rellenamos con los datos facilitados
        $vehicle = new Vehicle();
        $vehicle->setPlate($request->request->get('plate'));
        $vehicle->setModel($request->request->get('model'));
        $vehicle->setBrand($request->request->get('brand'));
        $vehicle->setColor($request->request->get('color'));
        $vehicle->setImagePath($request->request->get('image_path'));
        $vehicle->setPrice($request->request->get('price'));

        // Por defecto, cuando se inserta un vehiculo nuevo, este no se ha vendido
        $vehicle->setSold(false);
   
        $entityManager->persist($vehicle);
        $entityManager->flush();
        
        // Devolvemos un mensaje de acierto en JSON
        return $this->json('Vehículo insertado correctamente con id ' . $vehicle->getId());
    }

    // Funcion que rematricula la matricula de un coche (METODO PUT)
    #[Route('/vehicles/plate/{id}', name: 'vehicle_reregister', methods:['put', 'patch'] )]
    public function vehicle_reregister(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {

        // Buscamos el vehiculo por el ID proporcionado en la base de datos
        $entityManager = $doctrine->getManager();
        $vehicle = $entityManager->getRepository(Vehicle::class)->find($id);
   
        // Si no encontramos dicho vehiculo, devolvemos un mensaje de error en JSON con codigo de error 404
        if (!$vehicle) {
            return $this->json('No se ha encontrado ningún vehículo con id ' . $id, 404);
        }
   
        // Se aplica la nueva matricula al vehiculo
        $vehicle->setPlate($request->request->get('plate'));
        $entityManager->flush();

        // Devolvemos un mensaje de acierto en JSON
        return $this->json('Matrícula modificada correctamente del vehículo con id ' . $vehicle->getId());
    }

    // Funcion que vende un vehiculo, solo lo marca para no mostrarlo, no lo borra de la base de datos (METODO PUT)
    #[Route('/vehicles/sell/{id}', name: 'sell_vehicle', methods:['put', 'patch'] )]
    public function sell_vehicle(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {

        // Buscamos el vehiculo por el ID proporcionado en la base de datos
        $entityManager = $doctrine->getManager();
        $vehicle = $entityManager->getRepository(Vehicle::class)->find($id);
   
        // Si no encontramos dicho vehiculo, devolvemos un mensaje de error en JSON con codigo de error 404
        if (!$vehicle) {
            return $this->json('No se ha encontrado ningún vehículo con id ' . $id, 404);
        }
   
        // Se marca el vehiculo como vendido (sold)
        $vehicle->setSold(true);
        $entityManager->flush();

        // Devolvemos un mensaje de acierto en JSON
        return $this->json('Se ha vendido correctamente el vehículo con id ' . $vehicle->getId());
    }
}
