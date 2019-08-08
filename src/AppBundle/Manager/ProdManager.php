<?php
namespace AppBundle\Manager;


use AppBundle\Entity\Product;
use AppBundle\Repository\ProductRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @DI\Service("manager.product")
 */
class ProdManager implements ProductManagerInterface
{
    /**
     *
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * string
     */
    private $rootDir;

    private $request;

    /**
     * @DI\InjectParams({
     *     "productRepository" = @DI\Inject("service.repository.product"),
     *     "rootDir" = @DI\Inject("%kernel.root_dir%"),
     *     "requestStack" = @DI\Inject("request_stack")
     *     * })
     */
    public function __construct(ProductRepositoryInterface $productRepository,
                                string $rootDir,
                                RequestStack $requestStack
    ) {
        $this->productRepository = $productRepository;
        $this->rootDir = $rootDir;
        $this->request = $requestStack->getMasterRequest();
    }

    public function createProduct(Object $data) {
        $product = new Product();
        $product->setDesignation($data->designation);
        $product->setPrice($data->price);
        $product->setQuantity($data->quantity);
        $this->productRepository->save($product, true, true);
        if($data->image !== ""){
            $directory = sprintf('/product/%d', $product->getId());
            $images = $this->move($data->image, $directory);
            $product->setImage($images);
        }
        $this->productRepository->save($product, false, true);
        return $this->getSuccessMsg('Enregistrement avec success', $product);
    }

    public function move(string $base64Image, string $directory = '', string $ext = '.png')
    {
        $root = $this->rootDir . '/../web';
        $base64Image = preg_replace('/(data:image\/jpeg;base64,)/', '', $base64Image);
        $base64Image = preg_replace('/(data:image\/png;base64,)/', '', $base64Image);
        $timestamp = (new \DateTime())->format('Ymdhis');
        if (!empty($directory)) {
            if (0 !== strpos($directory, '/')) {
                $directory = '/' . $directory;
            }
            if (strlen($directory) - 1 !== strrpos($directory, '/')) {
                $directory .= '/';
            }
        }
        $dir = $root . $directory;
        if (!empty($dir) && (strlen($directory) - 1 !== strrpos($dir, '/'))) {
            $dir .= '/';
        }
        $filename = $timestamp . '_' . uniqid() . $ext;
        $fileSystem = new Filesystem();
        if (!$fileSystem->exists($dir)) {
            try {
                $fileSystem->mkdir($dir, 0775);
            } catch (IOExceptionInterface $exception) {
                return null;
            }
        }
        $path = $dir . $filename;
        $binary = base64_decode($base64Image);
        $file = fopen($path, 'wb');
        fwrite($file, $binary);
        fclose($file);
        $uploadedFile = $directory . $filename;
        return $uploadedFile;
    }

    public function getBaseUri()
    {
        if (null == $this->request) {
            return 'https://mighty-basin-25694.herokuapp.com';
        }
        $baseUri = $this->request->getScheme() . '://' . $this->request->getHttpHost(). $this->request->getBasePath();
        return $baseUri;
    }

    public function updateProduct(int $id,Object $data)
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            return $this->getErrorMsg('Produit introuvable', 404);
        }
        if (!is_object($data)) {
            return $this->getErrorMsg("error format json",500);
        }
        $product->setDesignation($data->designation);
        $product->setPrice($data->price);
        $product->setQuantity($data->quantity);
        if($data->image!== ""){
            $directory = sprintf('/product/%d', $product->getId());
            $images = $this->move($data->image, $directory);
            $product->setImage($images);
        }
        $this->productRepository->save($product, false, true);
        return $this->getSuccessMsg('Enregistrement avec success', $product);
    }


    public function getProduct(int $id)
    {
        $product = $this->productRepository->find($id);
        if($product->getImage()) {
            $product->setImage($this->getBaseUri() . $product->getImage());
        }
        return $this->getSuccessMsg('', $product);
    }

    public function remove(int $id)
    {
        $object = $this->productRepository->get($id);
        $this->productRepository->remove($object);
        return $this->getSuccessMsg('Suppression avec succes', '');
    }

    public function getProducts()
    {
        $products = $this->productRepository->getAllProduct();
        foreach ($products as $product){
            if($product->getImage()) {
                $product->setImage($this->getBaseUri() . $product->getImage());
            }
        }
        return $this->getSuccessMsg('', $products);
    }

    private function getSuccessMsg(String $msg, $data){
        return [
            'success'           => true,
            'message'           => $msg,
            'code'              => 200,
            'data'              => $data
        ];
    }

    private function getErrorMsg(String $msg, int $code){
        return [
            'success'           => false,
            'message'           => $msg,
            'code'              => $code,
            'data'              => ""
        ];
    }


}