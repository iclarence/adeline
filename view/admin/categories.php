<h1>Manage Categories</h1>

<div id="list_categories">
    <h2>List of categories</h2>
    <?php if (count($data) == 0): ?>
    <p>There are no categories listed.</p>
    <?php else: ?>
    <p><button class="add">add new category</button></p>
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>URL Name</th>
            <th>Active</th>
            <th>Priority</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    <?php foreach ($data as $key => $category): ?>
        <tr id="<?php echo 'row' . $category['id']; ?>" class="<?php echo ($category['id'] % 2 == 0 ? 'even' : 'odd'); ?>">
            <td class="category_id"><?php echo $category['id']; ?></td>
            <td class="category_name"><?php echo $category['name']; ?></td>
            <td class="url_name"><?php echo $category['url_name']; ?></td>
            <td class="active"><?php echo $category['active']; ?></td>
            <td class="priority"><?php echo $category['priority']; ?></td>
            <td><a href="<?php echo $this->getLink('admin/index.php?page=Subcategories&amp;category=' . $category['id']); ?>">subcategories</a></td>
            <td><button class="edit">edit</button></td>
            <td><button class="delete">delete</button></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div>

<div id="add_category">
    <h2>Adding a new category</h2>
    <table border="0" cellspacing="0" cellpadding="0">
        <form action="<?php echo $this->getLink('admin/index.php'); ?>" method="post">
        <input type="hidden" name="session_id" value="<?php echo session_id(); ?>" />
        <input type="hidden" name="page" value="Categories" />
        <input type="hidden" name="action" value="add" />
        <tr class="even">
            <td><label for="category_name">Category Name</label></td>
            <td><input type="text" id="category_name" name="category_name" /></td>
        </tr>
        <tr class="odd">
            <td><label for="url_name">URL Name</label></td>
            <td><input type="text" id="url_name" name="url_name" /></td>
        </tr>
        <tr class="even">
            <td><label for="active">Active</label></td>
            <td><input type="checkbox" id="active" name="active" value="on" checked="checked" /></td>
        </tr>
        <tr class="odd">
            <td><label for="priority">Priority</label></td>
            <td><input type="text" id="priority" name="priority" /></td>
        </tr>
        <tr class="even">
            <td></td>
            <td><button id="submit" name="submit">submit</button></td>
        </tr>
        <tr class="odd">
            <td></td>
            <td><button id="cancel" name="cancel">cancel</button></td>
        </tr>
        </form>
    </table>
</div>

<div id="edit_category">
    <h2>Editing a category</h2>
    <table border="0" cellspacing="0" cellpadding="0">
        <form action="<?php echo $this->getLink('admin/index.php'); ?>" method="post">
        <input type="hidden" name="session_id" value="<?php echo session_id(); ?>" />
        <input type="hidden" name="page" value="Categories" />
        <input type="hidden" name="action" value="edit" />
        <input type="hidden" id="category_id" name="category_id" />
        <tr class="even">
            <td><label for="category_name">Category Name</label></td>
            <td><input type="text" id="category_name" name="category_name" /></td>
        </tr>
        <tr class="odd">
            <td><label for="url_name">URL Name</label></td>
            <td><input type="text" id="url_name" name="url_name" /></td>
        </tr>
        <tr class="even">
            <td><label for="active">Active</label></td>
            <td><input type="checkbox" id="active" name="active" value="on" checked="checked" /></td>
        </tr>
        <tr class="odd">
            <td><label for="priority">Priority</label></td>
            <td><input type="text" id="priority" name="priority" /></td>
        </tr>
        <tr class="even">
            <td></td>
            <td><button id="submit" name="submit">submit</button></td>
        </tr>
        <tr class="odd">
            <td></td>
            <td><button id="cancel" name="cancel">cancel</button></td>
        </tr>
        </form>
    </table>
</div>

<div id="delete_category">
    <h2>Deleting a category</h2>
    <p>Are you sure you want to delete <span id="category_delete"></span>?</p>
    <form action="<?php echo $this->getLink('admin/index.php'); ?>" method="post">
    <input type="hidden" name="session_id" value="<?php echo session_id(); ?>" />
    <input type="hidden" name="page" value="Categories" />
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" id="category_id" name="category_id" />
    <p><button id="submit" name="submit">yes</button> <button id="cancel" name="cancel">no</button></p>
    </form>  
</div>
