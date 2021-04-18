//
//  ViewController.h
//  hero-password-keeper
//
//  Created by SoEasY on 17/04/2021.
//

#import <UIKit/UIKit.h>

@interface ViewController : UIViewController{
    
    IBOutlet UITextField *usernameField;
    IBOutlet UITextField *passordField;
    
    NSDictionary *dico;
}

- (IBAction)logMe:(id)sender;
- (IBAction)forgot:(id)sender;

@end

