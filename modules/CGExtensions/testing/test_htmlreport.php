<?php
namespace CGExtensions;
require_once('../../../include.php');

// note: query is independent from report
$map = array(0=>'yearID',1=>'teamID',2=>'lgID',3=>'playerID',4=>'salary');
$query = new query\csvfilequery(array('filename'=>'test_data/baseball_salaries.csv','offset'=>1,'limit'=>1000000,'map'=>$map));

// this defines the report
$baseball_report = new reports\tabular_report_defn();
$baseball_report->set_query($query);
$baseball_report->set_title('Baseball Salaries');
$baseball_report->set_description('Salaries by team');
// order of column definition is important
$baseball_report->define_column(new reports\tabular_report_defn_column('yearID','Year'));
$baseball_report->define_column(new reports\tabular_report_defn_column('lgID','League'));
$baseball_report->define_column(new reports\tabular_report_defn_column('teamID','Team'));
$baseball_report->define_column(new reports\tabular_report_defn_column('playerID','Player'));
$baseball_report->define_column(new reports\tabular_report_defn_column('salary','Salary','{$val|number_format:2}'));
$baseball_report->set_content_columns(array('playerID','salary'));

// define groups (from leftmost column to rightmost column)
$grp = new reports\tabular_report_defn_group('yearID');
$grp->add_header_line(new reports\tabular_report_defn_group_line(array('yearID'=>'{$val}',
                                                               'lgID'=>null,
                                                               'teamID'=>null,
                                                               'playerID'=>null,
                                                               'salary'=>null
                                                             )));
$grp->add_footer_line(new reports\tabular_report_defn_group_line(array('yearID'=>null,
                                                               'lgID'=>null,
                                                               'teamID'=>'Yearly Median:',
                                                               'playerID'=>null,
                                                               'salary'=>'{$grp_median|number_format:2}',
                                                             )));
$baseball_report->add_group($grp);
$grp = new reports\tabular_report_defn_group('lgID');
$grp->add_header_line(new reports\tabular_report_defn_group_line(array('yearID'=>null,
                                                               'lgID'=>'{$val}',
                                                               'teamID'=>null,
                                                               'playerID'=>null,
                                                               'salary'=>null,
                                                             )));
$grp->add_footer_line(new reports\tabular_report_defn_group_line(array('yearID'=>null,
                                                               'lgID'=>null,
                                                               'teamID'=>'League Total:',
                                                               'playerID'=>null,
                                                               'salary'=>'{$grp_sum|number_format:2}',
                                                             )));
$grp->add_footer_line(new reports\tabular_report_defn_group_line(array('yearID'=>null,
                                                               'lgID'=>null,
                                                               'teamID'=>'League Average:',
                                                               'playerID'=>null,
                                                               'salary'=>'{$grp_mean|number_format:2}',
                                                             )));
$baseball_report->add_group($grp);
$grp = new reports\tabular_report_defn_group('teamID');
$grp->add_header_line(new reports\tabular_report_defn_group_line(array('yearID'=>null,
                                                               'lgID'=>null,
                                                               'teamID'=>'{$val}',
                                                               'playerID'=>null,
                                                               'salary'=>null,
                                                             )));
$grp->add_footer_line(new reports\tabular_report_defn_group_line(array('yearID'=>null,
                                                               'lgID'=>null,
                                                               'teamID'=>'Team Total:',
                                                               'playerID'=>null,
                                                               'salary'=>'{$grp_sum|number_format:2}',
                                                             )));
$grp->add_footer_line(new reports\tabular_report_defn_group_line(array('yearID'=>null,
                                                               'lgID'=>null,
                                                               'teamID'=>'Team Average:',
                                                               'playerID'=>null,
                                                               'salary'=>'{$grp_mean|number_format:2}',
                                                             )));
$baseball_report->add_group($grp);

$generator = new reports\html_report_generator($baseball_report);
$generator->generate();
echo $generator->get_output();

?>