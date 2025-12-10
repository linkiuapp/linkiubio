

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta de Monitoreo - <?php echo e($alert->name); ?></title>
</head>
<body style="margin: 0; padding: 0; font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f1f5f9;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f1f5f9; padding: 34px;">
        <tr>
            <td align="left">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; margin: 0 auto;">
                    <!-- Logo -->
                    <tr>
                        <td style="padding-bottom: 24px;">
                            <?php if($logoUrl): ?>
                                <img src="<?php echo e($logoUrl); ?>" alt="Linkiu" style="display: block; height: 18px; width: auto; max-width: 98px; border: 0; outline: none; text-decoration: none;" />
                            <?php else: ?>
                                <div style="font-family: Inter, sans-serif; font-weight: 600; font-size: 18px; color: #155dfc;">Linkiu</div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <!-- Main Content Card -->
                    <tr>
                        <td style="background-color: #ffffff; border: 0.5px solid #cad5e2; border-radius: 8px; padding: 24px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <!-- Header with Icon -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="background-color: <?php echo e($alertTypeConfig['bgColor']); ?>; border: 1px solid <?php echo e($alertTypeConfig['borderColor']); ?>; border-radius: 8px; padding: 10px; vertical-align: middle;">
                                                    <div style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; text-align: center; line-height: 24px;">
                                                        <?php echo $alertTypeConfig['icon']; ?>

                                                    </div>
                                                </td>
                                                <td style="padding-left: 12px; vertical-align: middle;">
                                                    <h2 style="margin: 0; font-family: Inter, sans-serif; font-weight: 600; font-size: 16px; line-height: 24px; color: #020618;">
                                                        <?php echo e($alert->name); ?>

                                                    </h2>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- Greeting -->
                                <tr>
                                    <td style="padding-bottom: 8px;">
                                        <p style="margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;">
                                            Estimado administrador,
                                        </p>
                                    </td>
                                </tr>
                                
                                <!-- Alert Message -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <p style="margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158; white-space: pre-wrap;">
                                            <?php echo nl2br(e($message)); ?>

                                        </p>
                                    </td>
                                </tr>
                                
                                <!-- Alert Details Section -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <p style="margin: 0 0 16px 0; font-family: Inter, sans-serif; font-weight: 600; font-size: 14px; line-height: 20px; color: #314158;">
                                            Detalles de la alerta:
                                        </p>
                                        
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="padding: 16px 0;">
                                            <tr>
                                                <?php echo $alertDetails['features']; ?>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- CTA Button -->
                                <tr>
                                    <td style="padding-bottom: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="background-color: #155dfc; border: 1px solid #155dfc; border-radius: 8px; padding: 10px 20px;">
                                                    <a href="<?php echo e($appUrl); ?>/superlinkiu/monitoring" style="display: inline-block; text-decoration: none; font-family: Inter, sans-serif; font-weight: 500; font-size: 12px; line-height: 16px; color: #ffffff;">
                                                        Ver Dashboard de Monitoreo →
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- Closing -->
                                <tr>
                                    <td>
                                        <p style="margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;">
                                            Este es un mensaje automático del sistema de monitoreo de Linkiu.
                                            <br /><br />
                                            Atentamente,<br />
                                            El equipo de Linkiu
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding-top: 24px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="padding-bottom: 10px;">
                                        <p style="margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;">
                                            Hecho con <span style="color: #dc2626;">♥</span> por <a href="<?php echo e($appUrl); ?>" style="color: #155dfc; text-decoration: underline;">Linkiu</a>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;">
                                            Fecha: <?php echo e(now()->format('d/m/Y H:i:s')); ?>

                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/emails/plantillas-correo/monitoreo.blade.php ENDPATH**/ ?>