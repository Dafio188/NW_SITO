<?php
require_once __DIR__ . '/database.php';

class BookingCalendar {
    private $db;
    
    public function __construct() {
        $this->db = getDb();
    }
    
    /**
     * Ottiene le prenotazioni per un determinato mese
     */
    public function getBookingsForMonth($year, $month) {
        try {
            $startDate = sprintf('%04d-%02d-01', $year, $month);
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $stmt = $this->db->prepare("
                SELECT booking_date, COUNT(*) as count, 
                       GROUP_CONCAT(service_name) as services,
                       GROUP_CONCAT(participants) as participants_list
                FROM bookings 
                WHERE booking_date BETWEEN ? AND ? 
                AND status IN ('confirmed', 'pending', 'paid')
                GROUP BY booking_date
                ORDER BY booking_date
            ");
            
            $stmt->execute([$startDate, $endDate]);
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Organizza per data
            $bookingsByDate = [];
            foreach ($bookings as $booking) {
                $date = $booking['booking_date'];
                $bookingsByDate[$date] = [
                    'count' => $booking['count'],
                    'services' => explode(',', $booking['services']),
                    'participants' => array_sum(explode(',', $booking['participants_list']))
                ];
            }
            
            return $bookingsByDate;
            
        } catch (Exception $e) {
            error_log("Errore recupero prenotazioni calendario: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Verifica se una data è disponibile
     */
    public function isDateAvailable($date, $maxBookingsPerDay = 3) {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count
                FROM bookings 
                WHERE booking_date = ? 
                AND status IN ('confirmed', 'pending', 'paid')
            ");
            
            $stmt->execute([$date]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result['count'] < $maxBookingsPerDay;
            
        } catch (Exception $e) {
            error_log("Errore verifica disponibilità: " . $e->getMessage());
            return true; // In caso di errore, assume disponibile
        }
    }
    
    /**
     * Ottiene le prenotazioni per una data specifica
     */
    public function getBookingsForDate($date) {
        try {
            $stmt = $this->db->prepare("
                SELECT booking_id, service_name, booking_time, participants, status
                FROM bookings 
                WHERE booking_date = ? 
                AND status IN ('confirmed', 'pending', 'paid')
                ORDER BY booking_time
            ");
            
            $stmt->execute([$date]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            error_log("Errore recupero prenotazioni data: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Genera calendario HTML con disponibilità
     */
    public function generateCalendarHTML($year, $month) {
        $bookings = $this->getBookingsForMonth($year, $month);
        
        // Primo giorno del mese
        $firstDay = mktime(0, 0, 0, $month, 1, $year);
        $monthName = date('F Y', $firstDay);
        $daysInMonth = date('t', $firstDay);
        $dayOfWeek = date('w', $firstDay);
        
        $html = "<div class='calendar-container'>";
        $html .= "<div class='calendar-header'>";
        $html .= "<button onclick='changeMonth(-1)' class='calendar-nav'>‹</button>";
        $html .= "<h3>" . $this->getItalianMonthName($month) . " " . $year . "</h3>";
        $html .= "<button onclick='changeMonth(1)' class='calendar-nav'>›</button>";
        $html .= "</div>";
        
        $html .= "<div class='calendar-grid'>";
        
        // Intestazioni giorni
        $dayNames = ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'];
        foreach ($dayNames as $dayName) {
            $html .= "<div class='calendar-day-header'>{$dayName}</div>";
        }
        
        // Celle vuote per i giorni prima del primo del mese
        for ($i = 0; $i < $dayOfWeek; $i++) {
            $html .= "<div class='calendar-day empty'></div>";
        }
        
        // Giorni del mese
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $isToday = $date === date('Y-m-d');
            $isPast = $date < date('Y-m-d');
            
            $classes = ['calendar-day'];
            if ($isToday) $classes[] = 'today';
            if ($isPast) $classes[] = 'past';
            
            $bookingInfo = '';
            $availability = 'available';
            
            if (isset($bookings[$date])) {
                $booking = $bookings[$date];
                $classes[] = 'has-bookings';
                
                if ($booking['count'] >= 3) {
                    $classes[] = 'full';
                    $availability = 'full';
                } else {
                    $classes[] = 'partial';
                    $availability = 'partial';
                }
                
                $bookingInfo = "<div class='booking-info'>";
                $bookingInfo .= "<span class='booking-count'>{$booking['count']} prenotazioni</span>";
                $bookingInfo .= "<span class='participant-count'>{$booking['participants']} persone</span>";
                $bookingInfo .= "</div>";
            }
            
            $html .= "<div class='" . implode(' ', $classes) . "' data-date='{$date}' data-availability='{$availability}'>";
            $html .= "<span class='day-number'>{$day}</span>";
            $html .= $bookingInfo;
            $html .= "</div>";
        }
        
        $html .= "</div>"; // calendar-grid
        
        // Legenda
        $html .= "<div class='calendar-legend'>";
        $html .= "<div class='legend-item'><span class='legend-color available'></span> Disponibile</div>";
        $html .= "<div class='legend-item'><span class='legend-color partial'></span> Parzialmente prenotato</div>";
        $html .= "<div class='legend-item'><span class='legend-color full'></span> Tutto prenotato</div>";
        $html .= "</div>";
        
        $html .= "</div>"; // calendar-container
        
        return $html;
    }
    
    /**
     * Ottiene il nome del mese in italiano
     */
    private function getItalianMonthName($month) {
        $months = [
            1 => 'Gennaio', 2 => 'Febbraio', 3 => 'Marzo', 4 => 'Aprile',
            5 => 'Maggio', 6 => 'Giugno', 7 => 'Luglio', 8 => 'Agosto',
            9 => 'Settembre', 10 => 'Ottobre', 11 => 'Novembre', 12 => 'Dicembre'
        ];
        return $months[$month] ?? 'Mese';
    }
    
    /**
     * Genera CSS per il calendario
     */
    public function getCalendarCSS() {
        return "
        <style>
        .calendar-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(100, 255, 218, 0.2);
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .calendar-header h3 {
            margin: 0;
            color: #64ffda;
            font-size: 1.5rem;
        }
        
        .calendar-nav {
            background: rgba(100, 255, 218, 0.2);
            border: 1px solid rgba(100, 255, 218, 0.3);
            color: #64ffda;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .calendar-nav:hover {
            background: rgba(100, 255, 218, 0.3);
            transform: translateY(-2px);
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .calendar-day-header {
            background: rgba(0, 122, 255, 0.8);
            color: white;
            padding: 0.75rem;
            text-align: center;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .calendar-day {
            background: rgba(255, 255, 255, 0.05);
            min-height: 80px;
            padding: 0.5rem;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .calendar-day:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(100, 255, 218, 0.5);
        }
        
        .calendar-day.empty {
            background: rgba(255, 255, 255, 0.02);
            cursor: default;
        }
        
        .calendar-day.past {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .calendar-day.today {
            border-color: #64ffda;
            background: rgba(100, 255, 218, 0.1);
        }
        
        .calendar-day.available {
            border-left: 4px solid #28a745;
        }
        
        .calendar-day.partial {
            border-left: 4px solid #ffc107;
        }
        
        .calendar-day.full {
            border-left: 4px solid #dc3545;
            background: rgba(220, 53, 69, 0.1);
        }
        
        .day-number {
            font-weight: bold;
            color: white;
            font-size: 1.1rem;
        }
        
        .booking-info {
            position: absolute;
            bottom: 0.25rem;
            left: 0.25rem;
            right: 0.25rem;
            font-size: 0.7rem;
        }
        
        .booking-count {
            display: block;
            color: #64ffda;
            font-weight: bold;
        }
        
        .participant-count {
            display: block;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .calendar-legend {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
        
        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 3px;
        }
        
        .legend-color.available {
            background: #28a745;
        }
        
        .legend-color.partial {
            background: #ffc107;
        }
        
        .legend-color.full {
            background: #dc3545;
        }
        
        @media (max-width: 768px) {
            .calendar-day {
                min-height: 60px;
                padding: 0.25rem;
            }
            
            .day-number {
                font-size: 1rem;
            }
            
            .booking-info {
                font-size: 0.6rem;
            }
            
            .calendar-legend {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }
        }
        </style>";
    }
    
    /**
     * Genera JavaScript per il calendario
     */
    public function getCalendarJS() {
        return "
        <script>
        let currentMonth = " . date('n') . ";
        let currentYear = " . date('Y') . ";
        
        function changeMonth(direction) {
            currentMonth += direction;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            } else if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            
            console.log('Cambio mese a:', currentYear, currentMonth);
            loadCalendar(currentYear, currentMonth);
        }
        
        function loadCalendar(year, month) {
            // Mostra loading
            const calendarContainer = document.getElementById('booking-calendar');
            if (calendarContainer) {
                calendarContainer.innerHTML = '<div style=\"text-align: center; padding: 2rem; color: #64ffda;\"><div style=\"font-size: 2rem; margin-bottom: 1rem;\">🔄</div><p>Caricamento calendario...</p></div>';
            }
            
            // Crea URL per AJAX
            const url = window.location.pathname + '?page=booking&ajax=calendar&year=' + year + '&month=' + month;
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Errore di rete: ' + response.status);
                }
                return response.text();
            })
            .then(html => {
                if (calendarContainer) {
                    calendarContainer.innerHTML = html;
                    attachCalendarEvents();
                }
            })
            .catch(error => {
                console.error('Errore caricamento calendario:', error);
                if (calendarContainer) {
                    calendarContainer.innerHTML = '<div style=\"text-align: center; padding: 2rem; color: #dc3545;\"><div style=\"font-size: 2rem; margin-bottom: 1rem;\">❌</div><p>Errore caricamento calendario. Riprova.</p><button onclick=\"location.reload()\" style=\"background: #007aff; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; margin-top: 1rem;\">Ricarica</button></div>';
                }
            });
        }
        
        function attachCalendarEvents() {
            // Riattacca eventi ai pulsanti di navigazione
            const prevBtn = document.querySelector('.calendar-nav:first-child');
            const nextBtn = document.querySelector('.calendar-nav:last-child');
            
            if (prevBtn) {
                prevBtn.onclick = function() { changeMonth(-1); };
            }
            if (nextBtn) {
                nextBtn.onclick = function() { changeMonth(1); };
            }
            
            // Riattacca eventi ai giorni
            document.querySelectorAll('.calendar-day[data-date]').forEach(day => {
                day.addEventListener('click', function() {
                    const date = this.dataset.date;
                    const availability = this.dataset.availability;
                    
                    if (this.classList.contains('past')) {
                        alert('Non puoi prenotare per date passate');
                        return;
                    }
                    
                    if (availability === 'full') {
                        alert('Questa data è completamente prenotata. Scegli un\\'altra data.');
                        return;
                    }
                    
                    // Imposta la data nel form
                    const dateInput = document.getElementById('date');
                    if (dateInput) {
                        dateInput.value = date;
                        
                        // Evidenzia la data selezionata
                        document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
                        this.classList.add('selected');
                        
                        // Mostra info disponibilità
                        showAvailabilityInfo(date, availability);
                        
                        // Scroll al form
                        const formSection = document.getElementById('booking-form');
                        if (formSection) {
                            formSection.scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                });
            });
        }
        
        function showAvailabilityInfo(date, availability) {
            const info = document.getElementById('availability-info');
            if (!info) return;
            
            let message = '';
            let className = '';
            
            switch (availability) {
                case 'available':
                    message = '✅ Data completamente disponibile';
                    className = 'available';
                    break;
                case 'partial':
                    message = '⚠️ Data parzialmente prenotata - Posti limitati';
                    className = 'partial';
                    break;
                case 'full':
                    message = '❌ Data completamente prenotata';
                    className = 'full';
                    break;
            }
            
            info.innerHTML = '<div class=\"availability-message ' + className + '\" style=\"background: rgba(100, 255, 218, 0.1); border: 1px solid #64ffda; border-radius: 8px; padding: 1rem; margin: 1rem 0; color: #64ffda; text-align: center; font-weight: bold;\">' + message + '</div>';
        }
        
        // Inizializza eventi al caricamento
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                attachCalendarEvents();
            }, 100);
        });
        
        // Aggiungi CSS per selezione
        const style = document.createElement('style');
        style.textContent = `
            .calendar-day.selected {
                background: rgba(100, 255, 218, 0.3) !important;
                border: 2px solid #64ffda !important;
                transform: scale(1.05);
            }
            .availability-message.available {
                border-color: #28a745 !important;
                color: #28a745 !important;
                background: rgba(40, 167, 69, 0.1) !important;
            }
            .availability-message.partial {
                border-color: #ffc107 !important;
                color: #ffc107 !important;
                background: rgba(255, 193, 7, 0.1) !important;
            }
            .availability-message.full {
                border-color: #dc3545 !important;
                color: #dc3545 !important;
                background: rgba(220, 53, 69, 0.1) !important;
            }
        `;
        document.head.appendChild(style);
        </script>";
    }
}

// Funzione helper per ottenere l'istanza del calendario
function getBookingCalendar() {
    return new BookingCalendar();
}
?> 