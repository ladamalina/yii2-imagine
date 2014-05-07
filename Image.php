<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\imagine;

use Yii;
use Imagine\Image\Box;
use Imagine\Image\ManipulatorInterface;

/**
 * Image implements most commonly used image manipulation functions using the [Imagine library](http://imagine.readthedocs.org/).
 *
 * Example of use:
 *
 * ~~~php
 * // thumb - saved on runtime path
 * $imagePath = Yii::$app->getBasePath() . '/web/img/test-image.jpg';
 * $runtimePath = Yii::$app->getRuntimePath();
 * Image::thumbnail('@app/web/img/test-image.jpg', 120, 120)
 *     ->save('thumb-test-image.jpg', ['quality' => 50]);
 * ~~~
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Image extends BaseImage
{
    public static function adaptiveThumb($filename, $width, $height) {
        $width = intval($width);
        $height = intval($height);

        $image = static::getImagine()->open(Yii::getAlias($filename));
        $source_height = $image->getSize()->getHeight();
        $source_width = $image->getSize()->getWidth();

        $widthProportion = $width / $source_width;
        $heightProportion = $height / $source_height;

        if ($widthProportion > $heightProportion) {
            $newWidth = $width;
            $newHeight = round($newWidth / $source_width * $source_height);
        } else {
            $newHeight = $height;
            $newWidth = round($newHeight / $source_height * $source_width);
        }

        return $image
            ->resize(new Box($newWidth, $newHeight))
            ->thumbnail(new Box($width, $height), ManipulatorInterface::THUMBNAIL_OUTBOUND);
    }
}
