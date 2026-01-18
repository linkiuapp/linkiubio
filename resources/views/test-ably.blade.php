<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Prueba de Conexión Ably</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .log-container {
            max-height: 400px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }
        .log-success { color: #10b981; }
        .log-error { color: #ef4444; }
        .log-warning { color: #f59e0b; }
        .log-info { color: #3b82f6; }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">🧪 Prueba de Conexión Ably</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">1. Verificar Configuración Backend</h2>
            <button id="checkConfig" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Verificar Configuración
            </button>
            <div id="configResult" class="mt-4 p-4 bg-gray-50 rounded hidden"></div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">2. Probar Conexión Frontend</h2>
            <div class="mb-4">
                <label class="block mb-2">Store ID para prueba:</label>
                <input type="number" id="storeId" value="1" class="border rounded px-3 py-2 w-32">
            </div>
            <button id="testFrontend" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Probar Conexión Frontend
            </button>
            <div id="frontendStatus" class="mt-4 p-4 bg-gray-50 rounded hidden"></div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">3. Enviar Evento de Prueba</h2>
            <div class="mb-4">
                <label class="block mb-2">Store ID:</label>
                <input type="number" id="testStoreId" value="1" class="border rounded px-3 py-2 w-32">
            </div>
            <button id="sendTestEvent" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
                Enviar Evento de Prueba
            </button>
            <div id="eventResult" class="mt-4 p-4 bg-gray-50 rounded hidden"></div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">📋 Logs de Conexión</h2>
            <div id="logs" class="log-container bg-gray-900 text-white p-4 rounded">
                <div class="log-info">Esperando acciones...</div>
            </div>
            <button id="clearLogs" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Limpiar Logs
            </button>
        </div>
    </div>

    <!-- Cargar Pusher desde CDN -->
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    
    <!-- Exponer ABLY_KEY desde el backend -->
    @if(isset($ablyKey) && !empty($ablyKey))
    <script>
        window.VITE_ABLY_KEY = @json($ablyKey);
    </script>
    @endif
    
    <script>
        // Esperar a que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ DOM cargado, inicializando...');
            
            // Función para agregar logs
            function addLog(message, type = 'info') {
                const logs = document.getElementById('logs');
                if (!logs) {
                    console.log('[' + type.toUpperCase() + ']', message);
                    return;
                }
                const timestamp = new Date().toLocaleTimeString();
                const logClass = `log-${type}`;
                logs.innerHTML += `<div class="${logClass}">[${timestamp}] ${message}</div>`;
                logs.scrollTop = logs.scrollHeight;
            }

            // Verificar que Pusher esté cargado
            if (typeof Pusher !== 'undefined') {
                window.Pusher = Pusher;
                addLog('✅ Pusher cargado desde CDN', 'success');
            } else {
                addLog('⚠️ Pusher no se pudo cargar', 'warning');
            }

            // Verificar si VITE_ABLY_KEY está disponible
            if (window.VITE_ABLY_KEY) {
                addLog('✅ VITE_ABLY_KEY disponible desde backend', 'success');
            } else {
                addLog('⚠️ VITE_ABLY_KEY no disponible. Verifica .env', 'warning');
            }

            // Limpiar logs
            const clearLogsBtn = document.getElementById('clearLogs');
            if (clearLogsBtn) {
                clearLogsBtn.addEventListener('click', () => {
                    const logs = document.getElementById('logs');
                    if (logs) {
                        logs.innerHTML = '<div class="log-info">Logs limpiados...</div>';
                    }
                });
            }

            // Verificar configuración backend
            const checkConfigBtn = document.getElementById('checkConfig');
            if (checkConfigBtn) {
                checkConfigBtn.addEventListener('click', async () => {
                    addLog('Verificando configuración backend...', 'info');
                    try {
                        const response = await fetch('/test-ably/config');
                        const data = await response.json();
                        
                        const resultDiv = document.getElementById('configResult');
                        if (resultDiv) {
                            resultDiv.classList.remove('hidden');
                            resultDiv.innerHTML = `<pre class="text-sm">${JSON.stringify(data, null, 2)}</pre>`;
                        }
                        
                        if (data.success) {
                            addLog('✅ Configuración verificada: ' + data.message, 'success');
                        } else {
                            addLog('⚠️ ' + data.message, 'warning');
                        }
                    } catch (error) {
                        addLog('❌ Error: ' + error.message, 'error');
                    }
                });
            }

            // Probar conexión frontend
            const testFrontendBtn = document.getElementById('testFrontend');
            if (testFrontendBtn) {
                testFrontendBtn.addEventListener('click', () => {
                    addLog('Probando conexión frontend con Ably...', 'info');
                    
                    const storeIdInput = document.getElementById('storeId');
                    const storeId = storeIdInput ? storeIdInput.value : '1';
                    const statusDiv = document.getElementById('frontendStatus');
                    
                    if (statusDiv) {
                        statusDiv.classList.remove('hidden');
                    }
                    
                    // Verificar si VITE_ABLY_KEY está disponible
                    const ablyKey = window.VITE_ABLY_KEY;
                    
                    if (!ablyKey) {
                        if (statusDiv) {
                            statusDiv.innerHTML = '<div class="text-red-600">❌ VITE_ABLY_KEY no encontrado. Verifica que esté en .env (puede ser ABLY_KEY o VITE_ABLY_KEY)</div>';
                        }
                        addLog('❌ VITE_ABLY_KEY no encontrado', 'error');
                        return;
                    }
                    
                    addLog('✅ VITE_ABLY_KEY encontrado: ' + ablyKey.substring(0, 10) + '...', 'success');
                    
                    // Verificar si Pusher está disponible
                    if (typeof window.Pusher === 'undefined') {
                        if (statusDiv) {
                            statusDiv.innerHTML = '<div class="text-red-600">❌ Pusher no está disponible. Verifica que pusher-js esté cargado</div>';
                        }
                        addLog('❌ Pusher no disponible', 'error');
                        return;
                    }
                    
                    addLog('✅ Pusher disponible', 'success');
                    
                    try {
                        // Intentar crear conexión Ably
                        const ablyPublicKey = ablyKey.split(':')[0];
                        
                        if (!ablyPublicKey) {
                            throw new Error('No se pudo extraer la clave pública de Ably. Verifica el formato de la clave.');
                        }
                        
                        addLog('🔑 Clave pública extraída: ' + ablyPublicKey.substring(0, 10) + '...', 'info');
                        
                        const ablyPusher = new window.Pusher(ablyPublicKey, {
                            cluster: 'us-east-1-a', // Cluster requerido por Pusher (no se usa realmente con Ably)
                            wsHost: 'realtime-pusher.ably.io',
                            wsPort: 443,
                            wssPort: 443,
                            forceTLS: true,
                            enabledTransports: ['ws', 'wss'],
                            disableStats: true,
                        });
                        
                        addLog('🔌 Instancia de Pusher creada, esperando conexión...', 'info');
                        
                        ablyPusher.connection.bind('connected', () => {
                            if (statusDiv) {
                                statusDiv.innerHTML = '<div class="text-green-600">✅ Conectado a Ably exitosamente!</div>';
                            }
                            addLog('✅ Conectado a Ably exitosamente!', 'success');
                        });
                        
                        ablyPusher.connection.bind('error', (err) => {
                            const errorMsg = err ? (err.error ? err.error.message : JSON.stringify(err)) : 'Error desconocido';
                            if (statusDiv) {
                                statusDiv.innerHTML = '<div class="text-red-600">❌ Error de conexión: ' + errorMsg + '</div>';
                            }
                            addLog('❌ Error de conexión: ' + errorMsg, 'error');
                        });
                        
                        ablyPusher.connection.bind('disconnected', () => {
                            addLog('⚠️ Desconectado de Ably', 'warning');
                        });
                        
                        ablyPusher.connection.bind('state_change', (states) => {
                            addLog('🔄 Cambio de estado: ' + states.previous + ' → ' + states.current, 'info');
                        });
                        
                        // Suscribirse a un canal de prueba
                        const channelName = 'store.' + storeId + '.orders';
                        addLog('📡 Suscribiéndose al canal: ' + channelName, 'info');
                        
                        const channel = ablyPusher.subscribe(channelName);
                        
                        channel.bind('new.order', (data) => {
                            addLog('📦 Notificación recibida: ' + JSON.stringify(data), 'success');
                            if (statusDiv) {
                                statusDiv.innerHTML += '<div class="text-green-600 mt-2">📦 Notificación recibida correctamente!</div>';
                            }
                        });
                        
                        addLog('✅ Suscrito al canal: ' + channelName, 'success');
                        if (statusDiv) {
                            statusDiv.innerHTML = '<div class="text-blue-600">⏳ Intentando conectar a Ably...</div>';
                        }
                        
                    } catch (error) {
                        const errorMsg = error && error.message ? error.message : (error ? String(error) : 'Error desconocido');
                        if (statusDiv) {
                            statusDiv.innerHTML = '<div class="text-red-600">❌ Error: ' + errorMsg + '</div>';
                        }
                        addLog('❌ Error: ' + errorMsg, 'error');
                        console.error('Error completo:', error);
                    }
                });
            }

            // Enviar evento de prueba
            const sendTestEventBtn = document.getElementById('sendTestEvent');
            if (sendTestEventBtn) {
                sendTestEventBtn.addEventListener('click', async () => {
                    const testStoreIdInput = document.getElementById('testStoreId');
                    const storeId = testStoreIdInput ? testStoreIdInput.value : '1';
                    addLog('Enviando evento de prueba para store ID: ' + storeId, 'info');
                    
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]');
                        const response = await fetch('/test-ably/test-broadcast', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : ''
                            },
                            body: JSON.stringify({ store_id: storeId })
                        });
                        
                        const data = await response.json();
                        
                        const resultDiv = document.getElementById('eventResult');
                        if (resultDiv) {
                            resultDiv.classList.remove('hidden');
                            resultDiv.innerHTML = `<pre class="text-sm">${JSON.stringify(data, null, 2)}</pre>`;
                        }
                        
                        if (data.success) {
                            addLog('✅ Evento enviado: ' + data.message, 'success');
                            addLog('📡 Escuchando en canal: ' + data.channel, 'info');
                        } else {
                            addLog('❌ Error: ' + data.message, 'error');
                        }
                    } catch (error) {
                        addLog('❌ Error: ' + error.message, 'error');
                    }
                });
            }

            addLog('✅ Todos los botones inicializados correctamente', 'success');
        });
    </script>
</body>
</html>
