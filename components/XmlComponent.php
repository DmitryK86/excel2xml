<?php
namespace app\components;

use yii\web\NotFoundHttpException;

/**
 * Class XmlComponent
 * @package app\components
 */
class XmlComponent
{
	const MODE = 0777;

	protected $tags;
	protected $tagsData;

	protected $offerAttributes = ['offer available', 'id'];

	protected $path = 'outputs/xml/';
	protected $filename = 'offers.xml';

	public function __construct()
	{
		if (!is_dir($this->path)){
			mkdir($this->path, self::MODE, true);
		}
	}

	public function export($excelDataAsArray)
	{
        $tags = array_shift($excelDataAsArray);
        $this->prepareTags($tags);
        $this->tagsData = $excelDataAsArray;

		return $this->isFileExists() ? $this->addToExist() : $this->createNew();
	}

	public function getFile(){
        if(file_exists($this->path . $this->filename)){
            return \Yii::$app->response->sendFile($this->path . $this->filename, $this->filename,['Content-Type'=>'text/xml']);
        }else{
            throw new NotFoundHttpException('Такого файла не существует ');
        }
    }

    public function refresh(){
        if(file_exists($this->path . $this->filename)){
            return unlink($this->path . $this->filename);
        }

        return false;
    }

    public function isFileExists(){
        return file_exists($this->path . $this->filename);
    }

	protected function prepareTags($tags)
	{
        foreach ($tags as $key => $tag){
            if (in_array($tag, $this->offerAttributes)){
                unset($tags[$key]);
            }
        }

        $this->tags = array_map(function ($value){
            return explode(' ', $value);
        }, $tags);
	}

	protected function addToExist(){
	    $xmlStr = file_get_contents($this->path . $this->filename);
        $xml = new \SimpleXMLElement($xmlStr);
        $this->addOffers($xml->shop->offers);

        return $xml->saveXML($this->path . $this->filename);
    }

	protected function createNew()
    {
	    $xml = $this->getXml();
	    $offersElement = $xml->shop->addChild('offers');
        $this->addOffers($offersElement);

        return $xml->saveXML($this->path . $this->filename);
    }

    protected function addOffers(\SimpleXMLElement $offersElement){
        foreach ($this->tagsData as $tagData){
            $offer = $offersElement->addChild('offer');
            $offer->addAttribute('available', $tagData[0]);
            $offer->addAttribute('id', $tagData[1]);
            unset($tagData[0], $tagData[1]);

            foreach ($this->tags as $key => $tag){
                if (count($tag) > 1){
                    $elem = $offer->addChild($tag[0], $tagData[$key]);
                    $attrs = explode('="', $tag[1]);
                    $elem->addAttribute($attrs[0], $attrs[1]);
                }
                elseif (in_array('picture', $tag)){
                    $urls = explode(PHP_EOL, $tagData[$key]);
                    foreach ($urls as $url){
                        $offer->addChild($tag[0], $url);
                    }
                }
                else{
                    $offer->addChild($tag[0], $tagData[$key]);
                }
            }
        }
    }

	protected function getXml()
	{
		$xml = <<<XML
<?xml version='1.0' encoding="UTF-8"?>
<yml_catalog date="2011-07-20 14:58">
<shop>
<name>Тю-Тю!</name>
<company>Бренд Тю-Тю!</company>
<url>http://www.tyutyu.me/</url>
<currencies>
<currency id="UAH" rate="1"/>
</currencies>
<categories>
<category id="100">Женская одежда</category>
<category id="101" parentId="100">Воздушные юбки</category>
<category id="102" parentId="100">Платья-трансформеры</category>
<category id="103" parentId="100">Платья-рубашки</category>
<category id="104" parentId="100">Юбки</category>
<category id="105" parentId="100">Платья</category>
<category id="106" parentId="100">Топы</category>
<category id="107" parentId="100">Family look</category>
<category id="108" parentId="100">Воздушные юбки kids</category>
<category id="109" parentId="100">Воздушные юбки Teen</category>
<category id="110" parentId="100">Легкие летние платья</category>
<category id="111" parentId="100">Легкие летние топы</category>
<category id="112" parentId="100">Шорты</category>
<category id="113" parentId="100">Комплекты платья-трансформера AIRDRESS</category>
<category id="114" parentId="100">Съемные юбочки к платью-трансформеру AIRDRESS</category>
<category id="115" parentId="100">
Комплекты съемных юбочек к платью-трансформеру AIRDRESS
</category>
<category id="200">Товары для дома</category>
<category id="201" parentId="200">Емкости для хранения</category>
<category id="202" parentId="200">Тарелки и салатницы</category>
<category id="203" parentId="200">Стаканы</category>
<category id="204" parentId="200">Чашки</category>
<category id="205" parentId="200">Кувшины</category>
<category id="206" parentId="200">Вазы</category>
<category id="207" parentId="200">Масленки, лимонницы, икорницы, креманки</category>
<category id="208" parentId="200">Кружки</category>
<category id="209" parentId="200">Постельное белье из люкс-сатина</category>
<category id="210" parentId="200">Льняное постельное белье</category>
</categories>
</shop>
</yml_catalog>
XML;

		return new \SimpleXMLElement($xml);
	}
}