<div class="col-md-8">

  <div class="panel panel-default">

    <div class="panel-body">
        <div class="row settings-menu__row">
                        <div class="col-md-3">
                            <div class="settings-menu__title">Public</div>
                            <div class="settings-menu__description">Shown for any visitors</div>
                        </div>
                        <div class="col-md-9">
                            <div class="dd"> 
    <table class="table">
        <thead>
</thead>
        <tbody class="menu-sortable">
            <?php foreach($menus as $menu): ?>
<?php if($menu["visible"] == "External"): ?>
                <tr data-id="<?php echo $menu["id"]; ?>">
<td>
                        
                        
<div class="settings-menu__icon">
        <span class="<?php echo $menu["icon"]; ?>"></span>
    
                       <?php echo $menu["name"]; ?><div class="table__drag handle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Drag-Handle</title>
                                <path d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                            </svg></div>
                                            <?php if($menu["tiptext"]): ?>        
                         <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5"><?php echo $menu["tiptext"]; ?></span></div> 
<?php endif; ?>
                    </td>
<td>



<a data-toggle="modal" data-target="#modalDiv" data-action="edit_external" data-id="<?php echo $menu["id"]; ?>"  class="btn btn-default btn-xs dropdown-toggle btn-xs-caret">Edit</a>
</td>

                 </tr>   

                <?php endif; ?>
                <?php endforeach; ?>

</div>
        </tbody>
    </table>
</div>
<a data-toggle="modal" data-target="#modalDiv" data-action="add_external" data-id="<?php echo $menu["id"]; ?>"  class="btn btn-default m-b add-modal-menu">Add menu item</a>
             </div>      
</div>   

<div class="row settings-menu__row">
                        <div class="col-md-3">
                            <div class="settings-menu__title">Signed</div>
                            <div class="settings-menu__description">Available for signed in users</div>
                        </div>
                        <div class="col-md-9" >
                            <div class="dd" >
    <table class="table">
        <thead>
</thead>
        <tbody class="menu-sortable">
            <?php foreach($menus as $menu): ?>
<?php if($menu["visible"] == "Internal"): ?>
                <tr data-id="<?php echo $menu["id"]; ?>">
<td>
                        <div class="settings-menu__icon">
        <span class="<?php echo $menu["icon"]; ?>"></span>
    
                       <?php echo $menu["name"]; ?><div class="table__drag handle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Drag-Handle</title>
                                <path d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                            </svg></div>
                                                    
                        
<?php if($menu["tiptext"]): ?>        
                         <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5"><?php echo $menu["tiptext"]; ?></span></div> 
<?php endif; ?>
                    
                                                    
                        

                    </td>
<td>



<a data-toggle="modal" data-target="#modalDiv" data-action="edit_internal" data-id="<?php echo $menu["id"]; ?>"  class="btn btn-default btn-xs dropdown-toggle btn-xs-caret">Edit</a>
</td>

                 </tr>   

                <?php endif; ?>
                <?php endforeach; ?>
                        </div>
        </tbody>
    </table>
</div>
<a data-toggle="modal" data-target="#modalDiv" data-action="add_internal" data-id="<?php echo $menu["id"]; ?>"  class="btn btn-default m-b add-modal-menu">Add menu item</a> 
</div>
