<?php

namespace App\Http\Middleware;

use App\Models\VisitorCount;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
         // Get the current date in d-m-Y format
         $currentdate = date('Y-m-d');
         $month = date('M');
         $vyear = date('Y');
 
         
         // Get the client's IP address
         $clientIp = "$request->ip()";
 
         // Check if the current IP address has voted today
         $voteCount = VisitorCount::where('date', $currentdate)->where('ip_address', $clientIp)->count();
 
         // If the IP address hasn't voted today, record it
         if ($voteCount < 1) {
             $getvote = new VisitorCount();
             $getvote->date = $currentdate;
             $getvote->month = $month;
             $getvote->year = $vyear;
             $getvote->ip_address = $clientIp;
             $getvote->save();
         }

        return $next($request);
    }
}
