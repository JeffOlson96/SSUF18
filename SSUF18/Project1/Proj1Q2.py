#############################################################################
# Authors : John Salman, Jeff Olson, Ian Davidson                           #
# Assignment: Project 1, Problem 1                                          #
# Class: CS454 Theory of Computation                                        #
# Date: Sept 23, 2018                                                       #
#############################################################################

# psuedo_code Ravi gave us
# Input: A DFA M and a string
# Output: yes if w = w0.... wm-1 is in L, no else
# Assume state set Q = {0, 1,... ,n-1}
#
#
# Reach = [1, 0, 0, ..., 0] #Reach is a vector of length n
# temp = [0, 0, 0, ..., 0]
# for j from 0 to m-1 do:
#	temp = [0,0,0,...,0]
#	for k: Reach[k] == 1 do:
#		for every t in d(k,wj) do:
#			temp[t] = 1;
#		Reach = temp;
#	if Reach[j] == 1
#		return true
#	else
#		return false
#
#
#

import sys
import numpy as np
from numpy.linalg import matrix_power
from sympy import * # have sympy installed locally



def main():
	# MinString(DFA M) returns string(w) of shortest length accepted by DFA
	# BFS algo to solve this
	# smallestMultiple(int k, set S{0-9}) returns smallest positive int y that is a multiple of k
	
	M = np.eye(4 , dtype = int)
	print(M)
	M = np.delete(M, 2, 1)
	print(M)


main();
