<?php

require_once __DIR__.'/../../../../Source/Configuration/Classes/Configuration.php';
require_once __DIR__.'/../../../../Source/Utils/FileUpload/Classes/Image.php';
require_once __DIR__.'/../../../../Source/Utils/FileUpload/Classes/ImageUploader.php';
require_once __DIR__.'/../../../../Source/Utils/FileUpload/Classes/Target.php';
require_once __DIR__.'/HttpImageUploaderTestClass.php';

use Adamax\Configuration\Classes\Configuration;
use Adamax\Utils\FileUpload\Classes\Image;
use Adamax\Utils\FileUpload\Classes\ImageUploader;
use Adamax\Utils\FileUpload\Classes\Target;

class HttpImageUploaderTest extends PHPUnit_Framework_TestCase {
	
	protected $imageUploader;
	protected $target;

	protected function setUp() {
		$mockConfiguration = $this->getMockBuilder('Adamax\Configuration\Classes\Configuration')
			->disableOriginalConstructor()
			->getMock();
		
		$mockConfiguration->expects($this->any())
			->method('getTemporaryImageDirectory')
			->will($this->returnValue(__DIR__.'/../Upload/Temporary/'));
		
		$imageUploader = new ImageUploader();
		
		$this->imageUploader = new HttpImageUploaderTestClass($mockConfiguration, $imageUploader);
		$this->target = new Target('car', __DIR__.'/../Upload/Car/', '300', '200');
	}
	
	public function testGetErrors() {
		$this->prepare();
		
		$inputName1 = 'image_1';
		$inputName2 = 'image_2';
		$name1 = '10.jpg';
		$name2 = '12.jpg';
		$type = 'image/jpeg';
		$tmp_name = __DIR__.'/../Files/10.jpg';
		$error1 = 0;
		$error2 = 2;
		$size1 = 123;
		$size2 = 98174;
		
		$image1 = new Image($inputName1, $name1, $type, $tmp_name, $error1, $size1);
		$image1->addTarget($this->target);
		$image2 = new Image($inputName2, $name2, $type, $tmp_name, $error2, $size2);
		
		$this->imageUploader->restart();
		$this->imageUploader->addImage($image1);
		$this->imageUploader->addImage($image2);
		$this->imageUploader->upload();
		$result = $this->imageUploader->getErrors();
		$this->assertCount(1, $result);
		
		$this->clean();
	}
	
	public function testGetSuccess() {
		$this->prepare();
		
		$inputName1 = 'image_1';
		$inputName2 = 'image_2';
		$name1 = '10.jpg';
		$name2 = '12.jpg';
		$type = 'image/jpeg';
		$tmp_name = __DIR__.'/../Files/10.jpg';
		$error1 = 0;
		$error2 = 1;
		$size1 = 123;
		$size2 = 98174;
		
		$image1 = new Image($inputName1, $name1, $type, $tmp_name, $error1, $size1);
		$image1->addTarget($this->target);
		$image2 = new Image($inputName2, $name2, $type, $tmp_name, $error2, $size2);
		$image2->addTarget($this->target);
		
		$this->imageUploader->restart();
		$this->imageUploader->addImage($image1);
		$this->imageUploader->addImage($image2);
		$this->imageUploader->upload();
		$result = $this->imageUploader->getSuccess();
		$this->assertCount(1, $result);
		
		$this->clean();
	}
	
	public function testFileExistsSuccess() {
		$this->prepare();
		
		$inputName1 = 'image_1';
		$inputName2 = 'image_2';
		$name1 = '10.jpg';
		$name2 = '12.jpg';
		$type = 'image/jpeg';
		$tmp_name = __DIR__.'/../Files/10.jpg';
		$error1 = 0;
		$error2 = 1;
		$size1 = 123;
		$size2 = 98174;
		
		$image1 = new Image($inputName1, $name1, $type, $tmp_name, $error1, $size1);
		$image1->addTarget($this->target);
		$image2 = new Image($inputName2, $name2, $type, $tmp_name, $error2, $size2);
		$image2->addTarget($this->target);
		
		$this->imageUploader->restart();
		$this->imageUploader->addImage($image1);
		$this->imageUploader->addImage($image2);
		$this->imageUploader->upload();
		$results = $this->imageUploader->getSuccess();
		$result = $results['10.jpg'];
		$name = $result->getHashName();
		
		$this->assertFileExists(__DIR__.'/../Upload/Car/'.$name);
		
		$this->clean();
	}
	
	public function testTestTwoTargetOnOneInputSuccess() {
		$this->prepare();
		
		$inputName1 = 'image_1';
		$inputName2 = 'image_2';
		$name1 = '10.jpg';
		$name2 = '12.jpg';
		$type = 'image/jpeg';
		$tmp_name = __DIR__.'/../Files/10.jpg';
		$error1 = 0;
		$error2 = 1;
		$size1 = 123;
		$size2 = 98174;
		
		$image1 = new Image($inputName1, $name1, $type, $tmp_name, $error1, $size1);
		$target = new Target('input', __DIR__.'/../Upload/Car/', '300', '200');
		$targetMini = new Target('input', __DIR__.'/../Upload/Car/Mini/', '100', '66');
		$image1->addTarget($target);
		$image1->addTarget($targetMini);
		
		$this->imageUploader->restart();
		$this->imageUploader->addImage($image1);
		$this->imageUploader->upload();
		$results = $this->imageUploader->getSuccess();
		$this->assertCount(1, $results);
		$result = $results['10.jpg'];
		$name = $result->getHashName();

		$this->assertFileExists(__DIR__.'/../Upload/Car/'.$name);
		$this->assertFileExists(__DIR__.'/../Upload/Car/Mini/'.$name);
		
		$this->clean();
	}
	
	public function testTwoInputsSuccess() {
		$this->prepare();
		
		$inputName1 = 'image_1';
		$inputName2 = 'image_2';
		$name1 = '10.jpg';
		$name2 = '11.jpg';
		$type = 'image/jpeg';
		$tmp_name1 = __DIR__.'/../Files/10.jpg';
		$tmp_name2 = __DIR__.'/../Files/11.jpg';
		$error1 = 0;
		$error2 = 0;
		$size1 = 123;
		$size2 = 98174;
		
		$image1 = new Image($inputName1, $name1, $type, $tmp_name1, $error1, $size1);
		$target1 = new Target('input-A', __DIR__.'/../Upload/Car/', '300', '200');
		$image1->addTarget($target1);
		$image2 = new Image($inputName2, $name2, $type, $tmp_name2, $error2, $size2);
		$target2 = new Target('input-B', __DIR__.'/../Upload/Car/Banner/', '100', '66');
		$image2->addTarget($target2);
		
		$this->imageUploader->restart();
		$this->imageUploader->addImage($image1);
		$this->imageUploader->addImage($image2);
		$this->imageUploader->upload();
		$results = $this->imageUploader->getSuccess();
		
		$this->assertCount(2, $results);
		
		$result1 = $results['10.jpg'];
		$name1 = $result1->getHashName();
		$result2 = $results['11.jpg'];
		$name2 = $result2->getHashName();

		$this->assertFileExists(__DIR__.'/../Upload/Car/'.$name1);		
		$this->assertFileExists(__DIR__.'/../Upload/Car/Banner/'.$name2);
		
		$this->clean();
	}
	
	private function prepare() {
		\exec('cp '.__DIR__.'/../Storage/*.jpg '.__DIR__.'/../Files/');
	}
	
	private function clean() {
		\exec('find '.__DIR__.'/../Upload -depth -name "*.png" -type f -exec rm -f {} + ');
		\exec('rm '.__DIR__.'/../Files/*.jpg');
	}
}
