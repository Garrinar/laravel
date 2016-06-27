<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 03.05.2016
 * Time: 5:33
 */

namespace Garrinar\Helpers;


class Form
{
    public $elements = [];
    public $action = '';

    public function render()
    {
        ?>
        <form action="<?= $this->action ?>">
            <?php foreach ($this->elements as $k => $input): ?>
                <div class="col-md-4 col-md-offset-4">
                    <? if (is_array($input)): ?>
                        <select name="<?= $k ?>" id="<?= $k ?>" class="form-control">
                            <?php foreach ($input as $kk => $v): ?>
                                <option value="<?= $kk ?>"><?= $v ?></option>
                            <?php endforeach ?>
                        </select>
                    <? else: ?>
                        <input type="text" name="<?= $k ?>" placeholder="<?= $k ?>" id="<?= $k ?>" class="form-control">
                    <? endif ?>
                    <br>
                </div>
            <? endforeach ?>
        </form>
        <?
    }
}