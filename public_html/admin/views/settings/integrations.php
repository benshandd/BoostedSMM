	  
<div class="col-md-8">
                <div class="settings-emails__block">
        <div class="settings-emails__block-title">
            Active        </div>
        <div class="settings-emails__block-body">
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th class="settings-emails__th-name"></th>
                    <th class="settings-emails__th-actions"></th>
                </tr>
                </thead>
                <tbody>
            <?php foreach($methodList as $method): $extra = json_decode($method["method_extras"],true); ?>
              <?php if( $method["method_type"]==2 ):    ?>  <tr class="settings-emails__row">
                        <td class="settings-emails__row-img"><img src="<?php echo $method["link"]; ?>" alt="<?php echo $method["method_name"]; ?>"></td>        
<td><div class="settings-emails__row-name"><?php echo $method["method_name"]; ?></div><div class="settings-emails__row-description"><?php echo $method["description"]; ?></div>
                                                    </td>

                    <td class="settings-emails__td-actions">
                        <button type="button" class="btn btn-primary btn-xs pull-right edit-payment-method" data-toggle="modal" data-target="#modalDiv" data-action="edit_integration" data-id="<?php echo $method["method_get"]; ?>">Edit</button>
                    </td>
                </tr><?php endif; ?>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="col-md-8">
                <div class="settings-emails__block">
        <div class="settings-emails__block-title">
            Others       </div>
        <div class="settings-emails__block-body">
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th class="settings-emails__th-name"></th>
                    <th class="settings-emails__th-actions"></th>
                </tr>
                </thead>
                <tbody>
            <?php foreach($methodList as $method): $extra = json_decode($method["method_extras"],true); ?>
             <?php if( $method["method_type"]==1 ):    ?><tr class="settings-emails__row">
                        <td class="settings-emails__row-img"><img src="<?php echo $method["link"]; ?>" alt="<?php echo $method["method_name"]; ?>"></td>        
<td><div class="settings-emails__row-name"><?php echo $method["method_name"]; ?></div><div class="settings-emails__row-description"><?php echo $method["description"]; ?></div>
                                                    </td>

                    <td class="settings-emails__td-actions">
                        <button type="button" class="btn btn-primary btn-xs pull-right edit-payment-method" data-toggle="modal" data-target="#modalDiv" data-action="edit_integration" data-id="<?php echo $method["method_get"]; ?>">Activate</button>
                    </td>
                </tr>
<?php endif; ?>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>

    <link rel="stylesheet" type="text/css" href="https://smmeta.com/css/main.css">