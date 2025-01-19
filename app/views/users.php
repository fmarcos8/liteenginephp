<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>name</th>
            <th>created</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->username ?></td>
                <td><?= $user->created_at ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>