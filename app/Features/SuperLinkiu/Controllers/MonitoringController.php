<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MonitoringService;
use App\Models\ErrorLog;
use App\Models\MonitoringAlert;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    protected $monitoringService;

    public function __construct(MonitoringService $monitoringService)
    {
        $this->monitoringService = $monitoringService;
    }

    /**
     * Dashboard principal de monitoreo
     */
    public function index()
    {
        $summary = $this->monitoringService->getSummary(24);
        $errorsByDay = $this->monitoringService->getErrorsByDay(7);
        $trafficByDay = $this->monitoringService->getTrafficByDay(7);
        $topRoutes = $this->monitoringService->getTopRoutes(10, 24);
        $slowestRoutes = $this->monitoringService->getSlowestRoutes(10, 24);
        $recentErrors = $this->monitoringService->getRecentErrors(20);
        $statusCodes = $this->monitoringService->getStatusCodesDistribution(24);
        $topIPs = $this->monitoringService->getTopIPs(10, 24);
        $topStores = $this->monitoringService->getTopStores(10, 24);
        $alerts = MonitoringAlert::active()->get();

        return view('superlinkiu::monitoring.index', compact(
            'summary',
            'errorsByDay',
            'trafficByDay',
            'topRoutes',
            'slowestRoutes',
            'recentErrors',
            'statusCodes',
            'topIPs',
            'topStores',
            'alerts'
        ));
    }

    /**
     * Vista de errores con filtros
     */
    public function errors(Request $request)
    {
        $filters = $request->only(['level', 'route', 'store_id', 'user_id', 'date_from', 'date_to']);
        $recentErrors = $this->monitoringService->getRecentErrors(50, $filters);
        $availableRoutes = $this->monitoringService->getAvailableRoutes();

        return view('superlinkiu::monitoring.errors', compact('recentErrors', 'availableRoutes', 'filters'));
    }

    /**
     * Vista de tráfico
     */
    public function traffic(Request $request)
    {
        $hours = $request->get('hours', 24);
        $topRoutes = $this->monitoringService->getTopRoutes(20, $hours);
        $slowestRoutes = $this->monitoringService->getSlowestRoutes(20, $hours);
        $statusCodes = $this->monitoringService->getStatusCodesDistribution($hours);
        $topIPs = $this->monitoringService->getTopIPs(20, $hours);
        $topStores = $this->monitoringService->getTopStores(20, $hours);

        return view('superlinkiu::monitoring.traffic', compact(
            'topRoutes',
            'slowestRoutes',
            'statusCodes',
            'topIPs',
            'topStores',
            'hours'
        ));
    }

    /**
     * Vista de performance
     */
    public function performance()
    {
        $slowQueries = $this->monitoringService->getSlowQueries(20, 24);
        $slowestRoutes = $this->monitoringService->getSlowestRoutes(20, 24);

        return view('superlinkiu::monitoring.performance', compact('slowQueries', 'slowestRoutes'));
    }

    /**
     * Vista de detalles de error
     */
    public function showError($id)
    {
        $error = ErrorLog::with(['user', 'store'])->findOrFail($id);

        return view('superlinkiu::monitoring.error-detail', compact('error'));
    }
}
