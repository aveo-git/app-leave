<div style="max-width: 600px;min-width: 400px;padding: 20px 40px;background: #F9F9F9;">
    <p>Bonjour,</p>
    <p style="text-align: justify;">Votre demande de congé a été <?= $user->l_statut == '1' ? '<span style="background-color: #bdffc0; padding: 1px 5px; border-radius: 5px">validé</span>' : '<span style="background-color: #ffb2ba; padding: 1px 5px; border-radius: 5px">refusé</span>' ?> par votre supérieur. <br>
    </p>
    <p>Pour voir plus de détails, rendez-vous sur <a href="<?= base_url() ?>" target="blank"><?= base_url() ?></a>.</p>
    <p>
        <div>Bien cordialement.</div>
    </p>
</div>