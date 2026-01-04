<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'week'); // today, week, month, year
        
        $query = Visit::query();
        $startDate = now();
        $format = 'Y-m-d';
        
        switch ($period) {
            case 'today':
                $startDate = now()->startOfDay();
                $format = 'H:00';
                break;
            case 'week':
                $startDate = now()->subDays(7);
                break;
            case 'month':
                $startDate = now()->subMonth();
                break;
            case 'year':
                $startDate = now()->subYear();
                $format = 'Y-m';
                break;
        }
        
        $query->where('created_at', '>=', $startDate);
        
        // Key Metrics
        $totalViews = (clone $query)->count();
        $uniqueVisitors = (clone $query)->distinct('ip_hash')->count('ip_hash');
        
        // Avoid division by zero
        $daysDiff = max(1, now()->diffInDays($startDate));
        $avgPerDay = $totalViews / $daysDiff;
        
        // Chart Data
        $visits = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date, COUNT(*) as count, COUNT(DISTINCT ip_hash) as unique_visits")
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $labels = $visits->pluck('date');
        $pageViewsData = $visits->pluck('count');
        $uniqueVisitorsData = $visits->pluck('unique_visits');
        
        // Top Pages
        $topPages = Visit::select('url')
            ->selectRaw('COUNT(*) as views')
            ->where('created_at', '>=', $startDate)
            ->groupBy('url')
            ->orderByDesc('views')
            ->limit(10)
            ->get();
            
        return view('admin.analytics.index', compact(
            'totalViews', 
            'uniqueVisitors', 
            'avgPerDay', 
            'labels', 
            'pageViewsData', 
            'uniqueVisitorsData', 
            'topPages',
            'period'
        ));
    }
}
