<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AQAR {{ $academicYear }} - {{ $institutionName }}</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; font-size: 12px; color: #333; margin: 20px; }
        h1 { font-size: 18px; text-align: center; color: #1a237e; margin-bottom: 5px; }
        h2 { font-size: 14px; color: #1a237e; border-bottom: 2px solid #1a237e; padding-bottom: 5px; margin-top: 20px; }
        h3 { font-size: 12px; color: #333; margin-top: 15px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 11px; }
        th { background: #f5f5f5; font-weight: 600; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #1a237e; padding-bottom: 15px; }
        .subtitle { color: #666; font-size: 12px; }
        .summary-box { background: #f8f9fa; padding: 10px; border-radius: 4px; text-align: center; margin: 5px; }
        .summary-box .value { font-size: 20px; font-weight: bold; color: #1a237e; }
        .summary-box .label { font-size: 10px; color: #666; }
        .summary-grid { display: flex; flex-wrap: wrap; gap: 10px; margin: 15px 0; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $institutionName }}</h1>
        <h2 style="border:none;margin:0;">ANNUAL QUALITY ASSURANCE REPORT (AQAR)</h2>
        <p class="subtitle">Academic Year: {{ $academicYear }}</p>
        <p class="subtitle">Generated on: {{ $data['generated_on'] }}</p>
    </div>

    <div class="summary-grid">
        <div class="summary-box" style="flex:1;">
            <div class="value">{{ $data['summary']['total_activities'] }}</div>
            <div class="label">Total Activities</div>
        </div>
        <div class="summary-box" style="flex:1;">
            <div class="value">{{ $data['summary']['completed_activities'] }}</div>
            <div class="label">Completed</div>
        </div>
        <div class="summary-box" style="flex:1;">
            <div class="value">{{ $data['summary']['completion_rate'] }}%</div>
            <div class="label">Completion Rate</div>
        </div>
        <div class="summary-box" style="flex:1;">
            <div class="value">{{ $data['summary']['total_departments'] }}</div>
            <div class="label">Departments</div>
        </div>
        <div class="summary-box" style="flex:1;">
            <div class="value">{{ $data['summary']['total_faculty'] }}</div>
            <div class="label">Faculty Members</div>
        </div>
    </div>

    <h2>Part-A: Criterion-wise Summary</h2>
    <table>
        <thead>
            <tr>
                <th>Criterion No.</th>
                <th>Criterion Name</th>
                <th>Key Indicators</th>
                <th>Total Activities</th>
                <th>Completed</th>
                <th>Progress %</th>
            </tr>
        </thead>
        <tbody>
            @foreach($criteria as $c)
                @php
                    $pct = $c->total_activities > 0 ? round(($c->completed_activities / $c->total_activities) * 100) : 0;
                @endphp
                <tr>
                    <td>{{ $c->criterion_number }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->keyIndicators_count }}</td>
                    <td>{{ $c->total_activities }}</td>
                    <td>{{ $c->completed_activities }}</td>
                    <td>{{ $pct }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Part-B: Quality Indicators</h2>
    <table>
        <thead>
            <tr>
                <th>Area</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['quality_indicators'] as $area => $score)
                <tr>
                    <td>{{ ucwords(str_replace('_', ' ', $area)) }}</td>
                    <td>{{ $score }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Part-C: Additional Information</h2>
    <table>
        <tr><td><strong>Meetings Conducted</strong></td><td>{{ $data['summary']['meetings_conducted'] }} / {{ $data['summary']['meetings_total'] }}</td></tr>
        <tr><td><strong>Feedback Surveys</strong></td><td>{{ $data['summary']['feedback_surveys'] }}</td></tr>
        <tr><td><strong>Feedback Responses</strong></td><td>{{ $data['summary']['feedback_responses'] }}</td></tr>
        <tr><td><strong>Documents Maintained</strong></td><td>{{ $data['summary']['total_documents'] }}</td></tr>
    </table>

    @if($report->remarks)
        <h2>Remarks</h2>
        <p>{{ $report->remarks }}</p>
    @endif

    <div class="footer">
        <p>Prepared by: {{ $report->preparer->name ?? 'IQAC Coordinator' }}</p>
        <p>Status: {{ ucfirst($report->status) }}</p>
        @if($report->submitted_to_naac_on)
            <p>Submitted to NAAC on: {{ $report->submitted_to_naac_on->format('d M Y') }}</p>
        @endif
    </div>
</body>
</html>
